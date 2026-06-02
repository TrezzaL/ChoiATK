<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search nama produk
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
            // Mencari produk yang nama nya mengandung kata kunci pencarian (case-insensitive)
            // kata kuncinya diapit dengan % agar bisa mencari di tengah nama produk, bukan hanya di awal atau akhir
        }

        // Filter stok
        if ($request->filled('filter')) {

            if ($request->filter == 'habis') {

                $query->where('stok', 0);

            } elseif ($request->filter == 'menipis') {

                $query->where('stok', '>', 0)
                    ->whereColumn('stok', '<=', 'stok_minimum');
            }
        }

        // Ambil data produk yang sudah difilter dan diurutkan dari yang terbaru ditambahkan
        $products = $query->latest()->get();

        // Card statistik
        $stokHabis = Product::where('stok', 0)->count();

        $stokMenipis = Product::where('stok', '>', 0)
                            ->whereColumn('stok', '<=', 'stok_minimum')
                            ->count();

        return view('admin.product.index', compact(
            'products',
            'stokHabis',
            'stokMenipis'
        ));
    }

    public function create()
    {
        // Ambil semua kategori untuk dropdown di form tambah produk
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi inputan dari form tambah produk, memastikan aturan mengisi nya bener dan sesuai dengan yang diinginkan []
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:1',
            'foto' => 'nullable|image|max:2048', // Maks 2MB
        ]);

        // Ambil data dari form kecuali foto
        $data = $request->only([
            'category_id', 'nama', 'deskripsi',
            'harga', 'stok', 'stok_minimum'
        ]);

        // Kalau ada foto yang diupload, simpan dulu fotonya
        if ($request->hasFile('foto')) {
            // store('products', 'public') → simpan di storage/app/public/products/
            // dan diubah namanya sama laravel biar ga bentrok
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        //Perintah Eloquent untuk memasukkan seluruh isi array $data menjadi baris data produk baru di tabel products di database
        Product::create($data);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product) // route model binding otomatis mencari data produk berdasarkan id yang dikirim di URL, lalu datanya disimpan di variable $product
    {
        // Ambil semua kategori untuk dropdown di form edit produk
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:100|unique:products,nama,' . $product->id,
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'foto' => 'nullable|image|max:2048', // Maks 2MB
        ]);

        // Ambil data dari form kecuali foto dan is_aktif (karena is_aktif pakai checkbox, jadi harus dicek secara terpisah) maksudnya kalau checkbox is_aktif dicentang, berarti ada di request, kalau tidak dicentang, berarti tidak ada di request
        $data = $request->only([
        'category_id', 'nama', 'deskripsi',
        'harga', 'stok', 'stok_minimum'
        ]);

        // Kalau ada foto baru diupload, ganti fotonya
        if ($request->hasFile('foto')) { // Jika admin mengupload foto baru, maka simpan foto baru tersebut dan update path-nya di database, jika tidak ada foto baru yang diupload, maka biarkan path foto lama tetap tersimpan di database
            $data['foto'] = $request->file('foto')->store('products', 'public');
            // Simpan foto baru di storage/app/public/products/ dan simpan path-nya di $data['foto']
            // untuk diupdate ke database
        }

        // is_aktif pakai checkbox — kalau dicentang ada, kalau tidak dicentang tidak ada di request
        $data['is_aktif'] = $request->has('is_aktif') ? true : false;

        // Perintah Eloquent untuk mengupdate data produk yang sudah ada di database, dengan mengambil data yang diinputkan di form edit produk
        $product->update($data);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
