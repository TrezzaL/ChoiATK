<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil SEMUA order milik pelanggan ini terlebih dahulu
        $allOrders = auth()->user()->orders()->latest()->get();

        // 2. Kelompokkan berdasarkan waktu checkout (Tahun-Bulan-Tanggal Jam:Menit)
        // Ini memastikan 5 barang yang dibeli bersamaan hanya dihitung sebagai 1 Grup (1 Transaksi)
        $groupedOrders = $allOrders->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d H:i');
        });

        // 3. Hitung total seluruh transaksi (dihitung dari jumlah grup, bukan jumlah barang tunggal)
        $totalOrder = $groupedOrders->count();

        // 4. Hitung jumlah order berdasarkan status masing-masing grup
        // Karena 1 grup pasti memiliki status yang sama, kita cukup mengecek item pertamanya saja
        $diproses = $groupedOrders->filter(function ($group) {
            return $group->first()->status === 'diproses';
        })->count();

        $selesai = $groupedOrders->filter(function ($group) {
            return $group->first()->status === 'selesai';
        })->count();

        $menungguKonfirmasi = $groupedOrders->filter(function ($group) {
            return $group->first()->status === 'menunggu konfirmasi';
        })->count();

        // 5. Mengambil 5 transaksi terbaru untuk ditampilkan di tabel dashboard
        // Kita wakilkan setiap grup dengan item pertamanya, lalu tambahkan perhitungan total sementaranya
        $recentOrders = $groupedOrders->take(5)->map(function ($group) {
            $firstItem = $group->first();

            // Membuat properti dinamis sementara agar total harga sekeranjang bisa langsung dipanggil di Blade
            $firstItem->total_harga_grup = $group->sum('total_harga');
            $firstItem->jumlah_macam_barang = $group->count();

            return $firstItem;
        });

        return view('pelanggan.dashboard', compact(
            'totalOrder',
            'diproses',
            'selesai',
            'menungguKonfirmasi',
            'recentOrders'
        ));
    }
}
