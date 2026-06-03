<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class KatalogController extends Controller
{
    public function index (Request $request)
    {
        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Query produk yang aktif saja
        $query = Product::where('is_aktif', true)->with('category');

        // Filter berdasarkan kategori kalau dipilih
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Search berdasarkan nama produk
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Ambil hasil produk yang sudah difilter dan diurutkan terbaru
        $products = $query->latest()->get();

        return view('pelanggan.katalog', compact('products', 'categories'));
    }

}
