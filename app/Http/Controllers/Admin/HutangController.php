<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    // Menampilkan rekap seluruh hutang pelanggan
    public function index()
    {
        // Ambil semua orderan yang selesai, tapi metodenya hutang
        $daftarHutang = Order::where('metode_bayar', 'hutang')
            ->where('status', 'selesai')
            ->with('user', 'product') //relasi dengan user dan product agar bisa menampilkan nama user dan nama produk di view
            ->latest() // urutkan dari yang terbaru ditambahkan
            ->get();

        // Hitung total seluruh kas bon yang belum dibayar di toko
        $grandTotalHutang = $daftarHutang->sum('total_harga');

        return view('admin.hutang.index', compact('daftarHutang', 'grandTotalHutang'));
    }

    // Mengubah status hutang menjadi lunas (cash)
    public function lunaskan(Order $order) // Pastikan untuk menerima parameter Order untuk mencari data order yang tepat
    {
        // Ubah metode bayar dari hutang menjadi cash (artinya uangnya sudah masuk kasir)
        $order->update([
            'metode_bayar' => 'cash'
        ]);

        return back()->with('success', 'Pembayaran sukses! Hutang ' . $order->user->name . ' telah dilunaskan.');
    }
}
