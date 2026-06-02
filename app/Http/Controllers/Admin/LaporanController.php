<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Hitung jumlah sesi checkout unik per status.
     * Satu checkout keranjang (multi-produk) dihitung sebagai 1 order, bukan N baris.
     */
    // Fungsi ini meminta dua modal data (parameter) berupa teks saat dipanggil
    // INT = Menegaskan bahwa hasil akhir yang dikeluarkan oleh fungsi ini wajib berupa angka bulat (integer).
    private function countSessions(string $status, string $filter): int
    {
        $q = Order::where('status', $status);
        if ($filter === 'bulan') {
            $q->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
        }
        return $q->select('user_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i') as menit"))
                 ->groupBy('user_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"))
                 ->get()
                 ->count();
    }

    /**
     * Hitung total pendapatan dari order selesai.
     * Untuk menghindari double-count multi-item, sum total_harga per sesi,
     * lalu total semua sesi.
     */
    private function sumPendapatan(string $filter): int
    {
        $q = Order::where('status', 'selesai');
        if ($filter === 'bulan') {
            $q->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
        }
        // Sum semua baris selesai — ini benar karena setiap baris menyimpan subtotal produknya sendiri
        return (int) $q->sum('total_harga');
    }

    public function index()
    {
        $filter = request('filter', 'all');

        // ── 1. Statistik Box Atas ────────────────────────────────────────────
        $totalPendapatan   = $this->sumPendapatan($filter);

        // Hitung per SESI checkout (bukan per baris produk)
        $totalOrderSelesai = $this->countSessions('selesai', $filter);
        $totalOrderPending = $this->countSessions('menunggu konfirmasi', $filter);
        $totalOrderDitolak = $this->countSessions('ditolak', $filter);

        // ── 2. Produk Terlaris (berdasarkan qty terjual, status selesai) ─────
        $terlaris = Product::with('category')
            ->select('products.*')
            ->leftJoin('orders', function ($join) use ($filter) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai');
                if ($filter === 'bulan') {
                    $join->whereMonth('orders.created_at', now()->month)
                         ->whereYear('orders.created_at', now()->year);
                }
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->selectRaw('COUNT(orders.id) as orders_count')   // dipakai kondisi di blade
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        // ── 3. Produk Kurang Laku (qty paling sedikit, hanya yang pernah terjual) ─
        $jarangDibeli = Product::with('category')
            ->select('products.*')
            ->join('orders', function ($join) use ($filter) {   // inner join: harus pernah ada
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai');
                if ($filter === 'bulan') {
                    $join->whereMonth('orders.created_at', now()->month)
                         ->whereYear('orders.created_at', now()->year);
                }
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->groupBy('products.id')
            ->orderBy('total_terjual', 'asc')
            ->take(10)
            ->get();

        // ── 4. Produk yang belum pernah selesai terjual ──────────────────────
        $belumDiorder = Product::whereDoesntHave('orders', function ($q) {
            $q->where('status', 'selesai');
        })->with('category')->get();

        return view('admin.laporan', compact(
            'terlaris',
            'jarangDibeli',
            'belumDiorder',
            'totalPendapatan',
            'totalOrderSelesai',
            'totalOrderPending',
            'totalOrderDitolak'
        ));
    }


    public function exportPdf(Request $request)
    {
        $filter = $request->filter ?? 'all';

        $totalPendapatan   = $this->sumPendapatan($filter);
        $totalOrderSelesai = $this->countSessions('selesai', $filter);
        $totalOrderPending = $this->countSessions('menunggu konfirmasi', $filter);
        $totalOrderDitolak = $this->countSessions('ditolak', $filter);

        $terlaris = Product::with('category')
            ->select('products.*')
            ->leftJoin('orders', function ($join) use ($filter) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai');
                if ($filter === 'bulan') {
                    $join->whereMonth('orders.created_at', now()->month)
                         ->whereYear('orders.created_at', now()->year);
                }
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->selectRaw('COUNT(orders.id) as orders_count')
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        $jarangDibeli = Product::with('category')
            ->select('products.*')
            ->join('orders', function ($join) use ($filter) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai');
                if ($filter === 'bulan') {
                    $join->whereMonth('orders.created_at', now()->month)
                         ->whereYear('orders.created_at', now()->year);
                }
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->groupBy('products.id')
            ->orderBy('total_terjual', 'asc')
            ->take(10)
            ->get();

        $belumDiorder = Product::whereDoesntHave('orders', function ($q) {
            $q->where('status', 'selesai');
        })->with('category')->get();

        $pdf = Pdf::loadView('admin.laporan-pdf', compact(
            'terlaris',
            'jarangDibeli',
            'belumDiorder',
            'totalPendapatan',
            'totalOrderSelesai',
            'totalOrderPending',
            'totalOrderDitolak',
            'filter'
        ));

        return $pdf->download('laporan-choiatk.pdf');
    }
}
