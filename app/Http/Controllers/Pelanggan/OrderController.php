<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderBaruNotification;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Ambil data produk berdasarkan product_id yang dikirim dari form di katalog
        // lalu kirim datanya ke view form buat order
        $product = Product::findOrFail($request->product_id);
        return view('pelanggan.order.create', compact('product'));
    }

    public function store(Request $request) // Method untuk menyimpan data order baru ke database setelah pelanggan submit form buat order
    {
        // 1. Validasi request termasuk tipe_penyerahan dan logika wajib isi catatan
        $request->validate([
            'product_id'     => 'required|exists:products,id',
            'jumlah'         => 'required|integer|min:1',
            'tipe_penyerahan'=> 'required|in:ambil,antar',
            'metode_bayar'   => 'required|in:cash,hutang',

            // PERBAIKAN: Catatan wajib isi jika tipe penyerahan adalah 'antar'
            'catatan'        => 'required_if:tipe_penyerahan,antar|nullable|string|max:255',
        ], [
            // Pesan error custom biar lebih jelas kalau tembus validasi frontend
            'catatan.required_if' => 'Alamat lengkap wajib diisi jika pesanan minta diantar kurir!'
        ]);

        // 2. Validasi stok produk berdasarkan product_id yang dikirim dari form di katalog
        $product = Product::findOrFail($request->product_id);

        if ($product->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $product->stok);
        }

        // 3. Hitung total harga berdasarkan harga produk dan jumlah yang dipesan
        $totalHarga = $product->harga * $request->jumlah;

        // 4. Validasi Server-Side untuk Batas Minimal Diantar
        if ($request->tipe_penyerahan === 'antar' && $totalHarga < 10000) {
            return back()->with('error', 'Gagal mengirim pesanan. Opsi diantar hanya tersedia untuk pemesanan minimal Rp 10.000!');
        }

        // 5. Simpan order beserta tipe_penyerahan
        $order = Order::create([
            'user_id'         => auth()->id(),
            'product_id'      => $request->product_id,
            'jumlah'          => $request->jumlah,
            'total_harga'     => $totalHarga,
            'catatan'         => $request->catatan,
            'metode_bayar'    => $request->metode_bayar,
            'tipe_penyerahan' => $request->tipe_penyerahan, // Simpan ke DB
            'status'          => 'menunggu konfirmasi',
        ]);

        // 6. Kurangi stok produk di database berdasarkan jumlah yang dipesan
        $product->decrement('stok', $request->jumlah);

        // 7. Kirim notifikasi ke semua admin bahwa ada order baru yang masuk, dengan mengirim data order yang baru dibuat
        $admin = User::where('role', 'admin')->get();
        Notification::send($admin, new OrderBaruNotification($order));

        return redirect()->route('pelanggan.order.index')
            ->with('success', 'Order berhasil dikirim! Tunggu konfirmasi admin.');
    }

    public function index(Request $request)
    {
        // 1. Ambil query dasar pesanan milik user yang sedang login
        $query = Order::where('user_id', auth()->id())->with('product');

        // 2. FITUR BARU: Tangkap filter status jika ada yang dipilih oleh pelanggan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Eksekusi data pesanan hasil filter untuk ditampilkan di riwayat
        $filteredOrders = $query->latest()->get();

        // 4. Hitung TOTAL HUTANG (Wajib ambil dari seluruh data asli, jangan dari hasil filter!)
        $totalHutang = Order::where('user_id', auth()->id())
            ->where('metode_bayar', 'hutang')
            ->where('status', 'selesai')
            ->sum('total_harga');

        // 5. Kelompokkan pesanan yang sudah difilter berdasarkan waktu/menit pemesanan
        $orders = $filteredOrders->groupBy(function($item) {
            return $item->created_at->format('Y-m-d H:i');
        });

        // 6. Kirim seluruh data ke view (Pastikan totalHutang ikut dikirim ya!)
        return view('pelanggan.order.index', compact('orders', 'totalHutang'));
    }

    // Method untuk menampilkan detail pesanan, dengan route model binding otomatis mencari data order berdasarkan id yang dikirim di URL, lalu datanya disimpan di variable $order
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat detail order miliknya sendiri
        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        // Load relasi product untuk menampilkan nama produk di halaman detail order
        $order->load('product');
        return view('pelanggan.order.show', compact('order'));
    }
}
