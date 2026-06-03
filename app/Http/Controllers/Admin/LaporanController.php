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
     * Hitung jumlah sesi checkout unik per status dalam 30 Hari Terakhir.
     */
    private function countSessions(string $status): int
    {
        return Order::where('status', $status)
                 ->where('created_at', '>=', now()->subDays(30))
                 ->select('user_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i') as menit"))
                 ->groupBy('user_id', DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d %H:%i')"))
                 ->get()
                 ->count();
    }

    /**
     * Hitung total pendapatan dari order selesai dalam 30 Hari Terakhir.
     */
    private function sumPendapatan(): int
    {
        return (int) Order::where('status', 'selesai')
                 ->where('created_at', '>=', now()->subDays(30))
                 ->sum('total_harga');
    }

    public function index()
    {
        // ── 1. Statistik Box Atas (30 Hari Terakhir) ─────────────────────────
        $totalPendapatan   = $this->sumPendapatan();
        $totalOrderSelesai = $this->countSessions('selesai');
        $totalOrderPending = $this->countSessions('menunggu konfirmasi');
        $totalOrderDitolak = $this->countSessions('ditolak');

        // ── 2. Produk Terlaris ───────────────────────────────────────────────
        $terlaris = Product::with('category') 
            ->select('products.*')
            ->leftJoin('orders', function ($join) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai')
                     ->where('orders.created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->selectRaw('COUNT(orders.id) as orders_count')
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        // ── 3. Produk Kurang Laku ────────────────────────────────────────────
        $jarangDibeli = Product::with('category')
            ->select('products.*')
            ->join('orders', function ($join) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai')
                     ->where('orders.created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->groupBy('products.id')
            ->orderBy('total_terjual', 'asc')
            ->take(10)
            ->get();

        // ── 4. Produk yang belum pernah diorder dalam 30 Hari Terakhir ───────
        $belumDiorder = Product::whereDoesntHave('orders', function ($q) {
            $q->where('status', 'selesai')
              ->where('created_at', '>=', now()->subDays(30));
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
        $totalPendapatan   = $this->sumPendapatan();
        $totalOrderSelesai = $this->countSessions('selesai');
        $totalOrderPending = $this->countSessions('menunggu konfirmasi');
        $totalOrderDitolak = $this->countSessions('ditolak');

        $terlaris = Product::with('category')
            ->select('products.*')
            ->leftJoin('orders', function ($join) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai')
                     ->where('orders.created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->selectRaw('COUNT(orders.id) as orders_count')
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        $jarangDibeli = Product::with('category')
            ->select('products.*')
            ->join('orders', function ($join) {
                $join->on('orders.product_id', '=', 'products.id')
                     ->where('orders.status', '=', 'selesai')
                     ->where('orders.created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('COALESCE(SUM(orders.jumlah), 0) as total_terjual')
            ->groupBy('products.id')
            ->orderBy('total_terjual', 'asc')
            ->take(10)
            ->get();

        $belumDiorder = Product::whereDoesntHave('orders', function ($q) {
            $q->where('status', 'selesai')
              ->where('created_at', '>=', now()->subDays(30));
        })->with('category')->get();

        $pdf = Pdf::loadView('admin.laporan-pdf', compact(
            'terlaris',
            'jarangDibeli',
            'belumDiorder',
            'totalPendapatan',
            'totalOrderSelesai',
            'totalOrderPending',
            'totalOrderDitolak'
        ));

        return $pdf->download('laporan-choiatk-30hari.pdf');
    }
}
