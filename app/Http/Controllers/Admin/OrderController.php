<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    // Menampilkan daftar order dengan filter status dan pengelompokan berdasarkan waktu checkout
    public function index(Request $request)
    {
        // Ambil semua order dengan relasi ke user dan product untuk menampilkan nama user dan nama produk di view
        $query = Order::with('user', 'product');

        // 1. Terapkan filter status jika ada di request, misal admin memilih filter "Diproses" maka hanya order dengan status diproses yang akan ditampilkan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Pencarian berdasarkan Nama Pembeli (User Aktif) atau ID Order
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                // Bersihkan tanda # jika admin mengetikkan format ID (misal: #15)
                $cleanSearch = str_replace('#', '', $search);

                $q->where('id', 'LIKE', "%{$cleanSearch}%")
                  // Mencari ke dalam tabel users berdasarkan relasi user_id untuk mencocokkan nama pembeli dengan input pencarian
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Ambil data order, urutkan dari yang terbaru, lalu kelompokkan berdasarkan tanggal checkout (Y-m-d)
        $orders = $query
            ->latest()
            ->get()
            ->groupBy(function ($item) {    // Kelompokkan berdasarkan tanggal checkout (format Y-m-d) agar semua order yang dipesan di menit yang sama akan masuk dalam 1 kelompok yang sama
                return $item->created_at->format('Y-m-d');
            });

        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail order, termasuk semua order yang termasuk dalam 1 kelompok checkout (user + menit yang sama)
    public function show(Order $order) // route model binding otomatis mencari data order berdasarkan id yang dikirim di URL
    {
        // 1. Ambil format waktu menit pemesanan data saat ini
        $waktuSama = $order->created_at->format('Y-m-d H:i');

        // 2. Cari semua orderan milik user ini yang dibeli di menit yang sama (Sistem Kelompok Keranjang)
        $groupedOrders = Order::where('user_id', $order->user_id)
            ->where('created_at', 'LIKE', $order->created_at->format('Y-m-d H:i') . '%')
            ->with('product.category') // Eager load relasi product dan category untuk menghindari N+1 problem saat menampilkan nama produk dan kategori di view
            ->get();

        // 3. Hitung grand total akumulasi seluruh produk di dalam keranjang checkout ini
        $grandTotalGroup = $groupedOrders->sum('total_harga');

        // 4. Lempar data tambahan ke view blade
        return view('admin.orders.show', compact('order', 'groupedOrders', 'grandTotalGroup'));
    }

    /**
     * Ambil semua order dalam 1 kelompok checkout (user + menit yang sama).
     * Untuk menghindari duplikasi kode di method confirm(), complete(), dan reject() yang semuanya butuh data kelompok order yang sama.
     * Kita buat fungsi khusus untuk mengambil data kelompok order berdasarkan user_id dan waktu checkout yang sama
     */
    private function getGroupedOrders(Order $order)
    {
        return Order::where('user_id', $order->user_id)
            ->where('created_at', 'LIKE', $order->created_at->format('Y-m-d H:i') . '%')
            ->get();
    }

    // Method untuk mengonfirmasi pesanan (ubah status menjadi diproses),
    // diklik admin di halaman detail order yaitu tombol "Setujui Pesanan"
    public function confirm(Order $order) // route model binding otomatis mencari data order berdasarkan id yang dikirim di URL
    {
        // Cek apakah status order masih menunggu konfirmasi, agar tidak bisa diproses ulang
        if ($order->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        // Update seluruh kelompok keranjang sekaligus menjadi diproses
        // variable $group akan menampung semua data order yang termasuk dalam 1 kelompok checkout (user + menit yang sama)
        $group = $this->getGroupedOrders($order);
        foreach ($group as $item) { // Looping untuk update status setiap item di dalam kelompok checkout menjadi diproses
            $item->update(['status' => 'diproses']);
        }

        // LOGIKA BARU: Tentukan teks notifikasi secara dinamis berdasarkan tipe penyerahan
        $pesanNotif = ($order->tipe_penyerahan === 'antar')
            ? "SEDANG DIANTAR ke alamatmu! 🚚"
            : "SIAP DIAMBIL di konter toko! 🛍️";

        // Kirim notifikasi ke pelanggan bahwa pesanan mereka sudah disetujui dan sedang diproses
        $order->user->notify(new \App\Notifications\OrderNotification([ // Kirim notifikasi menggunakan OrderNotification yang sudah dibuat
            'pesan' => "Pesanan #" . $order->id . " (" . $order->product->nama . ") telah disetujui dan " . $pesanNotif,
            'url'   => route('pelanggan.order.show', $order->id)
            // Link notifikasi mengarah ke halaman detail order pelanggan
        ]));

        return back()->with('success', 'Pesanan berhasil disetujui dan sedang diproses!');
    }

    // Method untuk menyelesaikan pesanan (ubah status menjadi selesai),
    // diklik admin di halaman detail order yaitu tombol "Selesaikan Pesanan"
    public function complete(Order $order) // route model binding otomatis mencari data order berdasarkan id yang dikirim di URL
    {
        // Update seluruh kelompok keranjang menjadi selesai dengan memanggil method getGroupedOrders() untuk mengambil data kelompok order yang sama
        $group = $this->getGroupedOrders($order);
        foreach ($group as $item) { // Looping untuk update status setiap item di dalam kelompok checkout menjadi selesai
            $item->update(['status' => 'selesai']);
        }

        // Kirim notifikasi ke pelanggan
        $order->user->notify(new \App\Notifications\OrderNotification([
            'pesan' => "Hore! Pesanan #" . $order->id . " (" . $order->product->nama . ") telah SELESAI. Terima kasih!",
            'url'   => route('pelanggan.order.show', $order->id)
        ]));

        return redirect()->route('admin.order.index')->with('success', 'Pesanan berhasil diselesaikan!');
    }

    public function reject(Request $request, Order $order)
    {
        // Jika status order bukan menunggu konfirmasi, tampilkan error
        if ($order->status !== 'menunggu konfirmasi') {
            return back()->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'alasan_tolak' => 'required|string|max:255',
        ]);

        // Tolak dan kembalikan stok untuk seluruh kelompok
        $group = $this->getGroupedOrders($order);
        foreach ($group as $item) {
            $item->product->increment('stok', $item->jumlah);
            $item->update([
                'status'      => 'ditolak',
                'alasan_tolak' => $request->alasan_tolak,
            ]);
        }

        return back()->with('success', 'Pesanan telah ditolak.');
    }

    // Menampilkan halaman form order manual offline (seperti index order biasa tapi dengan form input untuk admin)
    public function createManual()
    {
        // Ambil semua produk yang stoknya masih di atas 0 agar admin bisa memilihnya
        $products = \App\Models\Product::where('stok', '>', 0)->orderBy('nama', 'asc')->get();
        return view('admin.orders.create_manual', compact('products'));
    }

    // Method 2: Memproses penyimpanan data belanja offline ke database
    // Setelah admin mengisi form order manual dan klik submit
    public function storeManual(Request $request)
    {
        // Validasi input admin
        $validated = $request->validate([
            'product_id'      => 'required|exists:products,id',
            'jumlah'          => 'required|integer|min:1',
            'nama_pembeli'    => 'required|string|max:100',
            'metode_bayar'    => 'required|in:cash,hutang',
            'tipe_penyerahan' => 'required|in:ambil,antar',
            'catatan'         => 'nullable|string',
        ], [
            'product_id.required'      => 'Produk wajib dipilih.',
            'product_id.exists'        => 'Produk tidak ditemukan.',
            'jumlah.required'          => 'Jumlah beli wajib diisi.',
            'jumlah.min'               => 'Jumlah beli minimal 1.',
            'nama_pembeli.required'    => 'Nama pembeli wajib diisi.',
            'metode_bayar.required'    => 'Metode pembayaran wajib dipilih.',
            'tipe_penyerahan.required' => 'Metode penyerahan wajib dipilih.',
        ]);

        // Cek stok produk
        $product = \App\Models\Product::findOrFail($request->product_id);

        // Validasi stok
        if ($product->stok < $request->jumlah) { // Jika stok tidak mencukupi, kembalikan ke form dengan pesan error yang menampilkan sisa stok saat ini
            return back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi! Sisa stok "' . $product->nama . '" saat ini: ' . $product->stok . ' pcs.');
        }

        // Validasi tambahan untuk metode penyerahan diantar dengan total harga minimal 10rb
        $totalHarga = $product->harga * $request->jumlah;


        $prefixPenyerahan = $request->tipe_penyerahan === 'antar' ? '[OFFLINE - DIANTAR]' : '[OFFLINE - DI KONTER]';
        $catatanFinal     = trim($prefixPenyerahan . ' Pembeli: ' . $request->nama_pembeli . '. ' . ($request->catatan ?? ''));

        // Simpan data order ke database dengan status langsung selesai karena ini adalah transaksi offline yang dilakukan langsung oleh admin
        Order::create([
            'user_id'         => auth()->id(),
            'product_id'      => $request->product_id,
            'jumlah'          => $request->jumlah,
            'total_harga'     => $totalHarga,
            'status'          => 'selesai',
            'catatan'         => $catatanFinal,
            'metode_bayar'    => $request->metode_bayar,
            'tipe_penyerahan' => $request->tipe_penyerahan,
        ]);

        // Kurangi stok produk sesuai jumlah yang dibeli
        $product->decrement('stok', $request->jumlah);

        return redirect()->route('admin.order.index')
            ->with('success', 'Transaksi offline "' . $request->nama_pembeli . '" — ' . $product->nama . ' (' . $request->jumlah . ' pcs) berhasil dicatat!');
    }
}
