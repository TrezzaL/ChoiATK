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
        // 1. Ambil semua orderan mentah yang selesai & berstatus hutang
        $rawHutang = Order::where('metode_bayar', 'hutang')
            ->where('status', 'selesai')
            ->with('user', 'product')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 2. KELOMPOKKAN berdasarkan User ID dan Waktu Checkout (Menit yang sama)
        $daftarHutang = $rawHutang->groupBy(function ($item) {
            // Gabung ID User dan Menit Checkout jadi 1 kunci (key) grup
            return $item->user_id . '_' . $item->created_at->format('Y-m-d H:i');
        });

        // 3. Hitung total seluruh kas bon yang belum dibayar di toko
        $grandTotalHutang = $rawHutang->sum('total_harga');

        return view('admin.hutang.index', compact('daftarHutang', 'grandTotalHutang'));
    }

    // Mengubah status hutang SATU KELOMPOK menjadi lunas (cash)
    public function lunaskan(Order $order)
    {
        // 1. Cari SEMUA barang yang dihutangkan oleh user ini pada menit yang sama
        $group = Order::where('user_id', $order->user_id)
            ->where('created_at', 'LIKE', $order->created_at->format('Y-m-d H:i') . '%')
            ->where('metode_bayar', 'hutang')
            ->get();

        // 2. Loop dan ubah metode bayarnya jadi cash (LUNAS) semuanya
        foreach ($group as $item) {
            $item->update([
                'metode_bayar' => 'cash'
            ]);
        }

        return back()->with('success', 'Pembayaran sukses! Seluruh tagihan bon milik ' . $order->user->name . ' telah dilunaskan.');
    }
}
