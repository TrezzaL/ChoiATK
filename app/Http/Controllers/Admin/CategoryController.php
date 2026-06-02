<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Tampilkan daftar kategori
    public function index ()
    {
        //membuat variable category dan mengambil datanya di database dengan menghitung product
        //nya ada berapa, diurutkan nya dari paling terbaru ditambahkan
        $categories = Category::with('products')
        ->withCount('products')
        ->latest()
        ->get();

        //dikembalikan ke view folder admin, folder category ke index.blade.php
        //lalu dipaketkan(compact), biar nanti tinggal dipanggil saja di view nya,
        //tanpa harus buat variable baru lagi
        return view('admin.category.index', compact('categories'));
    }

    //form tambah kategori
    public function create ()
    {
        //kalo user pencet tambah category nanti masuk ke sini
        return view('admin.category.create');
    }

    // Simpan kategori baru ke database
    //Request itu yang diketik sama user di form tambah category, nanti bisa dipanggil dengan $request->nama, $request->deskripsi
    public function store(Request $request) // Pastikan untuk menerima parameter Request untuk mengambil data dari form
    {
        //validasi inputan dari form tambah category, memastikan aturan mengisi nya bener dan sesuai dengan yang diinginkan []
        $request->validate([
            'nama' => 'required|string|max:100|unique:categories,nama',
            'deskripsi' => 'nullable|string|max:225',
        ]);

        // Menyimpan data kategori baru ke database menggunakan metode create().
        // $request->only() memastikan hanya kolom 'nama' dan 'deskripsi' yang aman yang akan disimpan.
        Category::create($request->only('nama', 'deskripsi'));

        //kalo udah berhasil disimpan, nanti diarahkan ke halaman index category dengan pesan sukses
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Tampilkan form edit
    // Category itu model binding dari table Category, jadi nanti otomatis akan mencari data
    // category yang sesuai dengan id yang dikirim di URL, lalu datanya disimpan di variable $category
    public function edit(Category $category)
    {
        //kalo user pencet edit category nanti masuk ke sini, dengan membawa data category yang mau diedit
        return view('admin.category.edit', compact('category'));
    }

    // Update kategori di database, setelah user klik simpan editan
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama'      => 'required|string|max:100|unique:categories,nama,' . $category->id,
            'deskripsi' => 'nullable|string|max:255',
        ]);

        //update data category yang sudah ada di database, dengan mengambil data yang diinputkan di form edit category
        $category->update($request->only('nama', 'deskripsi'));

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        // Cek dulu — kalau masih ada produk di kategori ini, tidak boleh dihapus
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.category.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih ada produk di dalamnya!');
        }

        //hapus data category yang sudah ada di database, sesuai dengan data category yang dipilih untuk dihapus
        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
