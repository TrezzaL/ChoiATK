<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Mengambil semua item keranjang milik user yang login beserta data produknya
        $cartItems = Cart::with('product')
                         ->where('user_id', Auth::id())
                         ->get();

        // Menghitung total belanjaan di keranjang
        $totalBelanja = $cartItems->sum(function($item) {
            return $item->product->harga * $item->quantity;
        });

        return view('pelanggan.cart.index', compact('cartItems', 'totalBelanja'));
    }

    public function store(Request $request)
    {
        // 1. Validasi proteksi login untuk response AJAX & Biasa
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Validasi input disamakan menjadi 'quantity'
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        // 3. Ambil jumlah produk secara dinamis, fallback ke 'jumlah' untuk jaga-jaga
        $qty = $request->input('quantity', $request->input('jumlah', 1));

        // 4. Cari tahu apakah produk ini sudah pernah ada di keranjang user
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, tinggal tambahkan kuantitasnya
            $cartItem->quantity += $qty;
            $cartItem->save();
        } else {
            // JALUR BYPASS MASS-ASSIGNMENT: Menggunakan instansiasi objek manual
            // Ini menjamin angka 3 tidak akan direset jadi 1 meskipun lupa setting $fillable di Model
            $newCart = new Cart();
            $newCart->user_id = Auth::id();
            $newCart->product_id = $request->product_id;
            $newCart->quantity = $qty;
            $newCart->save();
        }

        // 5. KUNCI UTAMA SINKRONISASI AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!'
            ]);
        }

        // Fallback jika diakses secara tradisional tanpa AJAX
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Pastikan user hanya bisa update cart miliknya sendiri
        if ((int) $cart->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('pelanggan.cart.index')->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        // Pastikan user hanya bisa hapus cart miliknya sendiri
        if ((int) $cart->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('pelanggan.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout()
    {
        // 1. Ambil semua item di keranjang milik user yang sedang login
        $cartItems = \App\Models\Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        // 2. Jika keranjang kosong tapi maksa akses checkout, balikin ke keranjang
        if ($cartItems->isEmpty()) {
            return redirect()->route('pelanggan.cart.index')->with('error', 'Keranjang kamu kosong, tidak bisa checkout.');
        }

        // 3. Hitung total belanja keseluruhan
        $totalBelanja = $cartItems->sum(function($item) {
            return $item->product->harga * $item->quantity;
        });

        // 4. Oper data ke halaman checkout blade yang akan kita buat setelah ini
        return view('pelanggan.checkout', compact('cartItems', 'totalBelanja'));
    }

    public function checkoutStore(Request $request)
    {
        // 1. Validasi request penyerahan & pembayaran
        $request->validate([
            'metode_bayar'       => 'required|in:cash,hutang',
            'metode_pengantaran' => 'required|in:ambil,diantar',
            'catatan'            => 'nullable|string|max:500',
        ]);

        $user = auth()->user(); // Ambil data user yang sedang login
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('pelanggan.cart.index')->with('error', 'Keranjang belanja kamu kosong!');
        }

        // 2. Hitung total belanjaan keseluruhan keranjang
        $grandTotal = $cartItems->sum(function($item) {
            return $item->product->harga * $item->quantity;
        });

        // 3. SINKRONISASI VALIDASI: Jika pilih diantar tapi belanjaan kurang dari 10rb, TOLAK!
        if ($request->metode_pengantaran == 'diantar' && $grandTotal < 10000) {
            return redirect()->route('pelanggan.cart.index')
                ->with('error', 'Gagal Checkout! Minimal pembelian untuk layanan antar kurir adalah Rp 10.000. Belanjaan Anda baru Rp ' . number_format($grandTotal, 0, ',', '.'));
        }

        // Cek ketersediaan stok produk sebelum eksekusi
        foreach ($cartItems as $item) {
            if ($item->product->stok < $item->quantity) {
                return redirect()->route('pelanggan.cart.index')
                    ->with('error', 'Gagal checkout! Stok produk ' . $item->product->nama . ' tidak mencukupi.');
            }
        }

        $orderPertama = null;

        // Loop penyimpanan item keranjang menjadi baris transaksi order
        foreach ($cartItems as $item) {
            // Formatisasi catatan pengiriman agar admin langsung paham di invoice
            $catatanFinal = $request->catatan;
            if ($request->metode_pengantaran == 'diantar') {
                $catatanFinal = "[DIANTAR TOKO] Alamat: " . $request->catatan;
            } else {
                $catatanFinal = "[AMBIL DI TOKO] " . $request->catatan;
            }

            $order = \App\Models\Order::create([
                'user_id'         => $user->id,
                'product_id'      => $item->product_id,
                'jumlah'          => $item->quantity,
                'total_harga'     => $item->product->harga * $item->quantity,
                'status'          => 'menunggu konfirmasi',
                'catatan'         => $catatanFinal,
                'metode_bayar'    => $request->metode_bayar,
                'tipe_penyerahan' => $request->metode_pengantaran == 'diantar' ? 'antar' : 'ambil'
            ]);

            if (!$orderPertama) {
                $orderPertama = $order;
            }

            $item->product->decrement('stok', $item->quantity);
        }

        if ($orderPertama) {
            $orderPertama->refresh();
            $orderPertama->total_harga = $grandTotal;

            $admin = \App\Models\User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new \App\Notifications\OrderBaruNotification($orderPertama));
            }
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('pelanggan.order.index')->with('success', 'Pesananmu berhasil dibuat!');
    }
}
