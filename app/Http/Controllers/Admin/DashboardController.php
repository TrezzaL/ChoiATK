<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total produk yang aktif
        $totalProduk  = Product::where('is_aktif', true)->count();

        // Hitung produk yang stoknya menipis (stok <= stok_minimum)
        $stokMenipis  = Product::whereColumn('stok', '<=', 'stok_minimum')->count();

        // Hitung jumlah order yang statusnya "Menunggu Konfirmasi"
        // Menggunakan distinct()=memnbuang duplikat agar baris dengan waktu checkout
        // yang sama hanya dihitung 1 kali
        $orderPending = Order::where('status', 'Menunggu Konfirmasi')
                     ->distinct('created_at')
                     ->count('created_at');

        // Ambil 5 order terbaru untuk ditampilkan di dashboard dengan relasi ke user dan product agar
        // bisa menampilkan nama user dan nama produk di dashboard
        $orderTerbaru = Order::with('user', 'product')
            ->latest()
            ->take(5)
            ->get();

        // Hitung jumlah produk yang stoknya habis
        $stokHabis = Product::where('stok', 0)->count();

        return view('admin.dashboard', compact(
            'totalProduk',
            'stokMenipis',
            'orderPending',
            'orderTerbaru',
            'stokHabis'
        ));
    }
}
