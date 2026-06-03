<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboard;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrder;
use App\Http\Controllers\Pelanggan\CartController;
use App\Http\Controllers\Pelanggan\KatalogController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Admin\HutangController;

// get untuk menampilkan halaman, post untuk menyimpan data, patch untuk update data, delete untuk menghapus data
// post untuk menyimpan data, patch untuk update data, delete untuk menghapus data
// resource untuk membuat route otomatis berdasarkan konvensi RESTful (index, create, store, show, edit, update, destroy)
// patch untuk update data, delete untuk menghapus data, get untuk menampilkan halaman, post untuk menyimpan data
// put untuk update data, delete untuk menghapus data, get untuk menampilkan halaman, post untuk menyimpan data
Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', function () {
    $categories = Category::all(); // Mengambil semua kategori dari database menggunakan model Category dan menyimpannya dalam variabel $categories.
    $products = Product::where('is_aktif', true)->with('category')->get(); // Mengambil semua produk yang aktif (is_aktif = true) dari database menggunakan model Product, termasuk relasi dengan kategori (with('category')), dan menyimpannya dalam variabel $products. Dengan cara ini, kita bisa menampilkan informasi produk beserta kategori terkait di halaman landing.
    return view('landing', compact('categories', 'products'));
})->name('landing'); // Route untuk menampilkan halaman landing, dengan nama route 'landing'. Halaman ini akan menampilkan daftar kategori dan produk yang diambil dari database.

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Route untuk menampilkan halaman edit profil, dengan nama route 'profile.edit'. Halaman ini akan menggunakan metode 'edit' dari ProfileController untuk menampilkan form edit profil kepada pengguna yang sudah terautentikasi.
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Awal Route Admin
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function ()
{
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Category
    Route::resource('category', CategoryController::class);

    // Product
    Route::resource('product', ProductController::class);

    // Order Manual}
    Route::get('/orders/create-manual', [AdminOrder::class, 'createManual'])->name('order.create_manual');
    Route::post('/orders/store-manual', [AdminOrder::class, 'storeManual'])->name('order.store_manual');

    // Order Manajemen
    Route::get('/orders', [AdminOrder::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('order.show');
    Route::patch('/orders/{order}/confirm', [AdminOrder::class, 'confirm'])->name('order.confirm');
    Route::patch('/orders/{order}/complete', [AdminOrder::class, 'complete'])->name('order.complete');
    Route::patch('/orders/{order}/reject', [AdminOrder::class, 'reject'])->name('order.reject');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');

    // Notifikasi
    // Route untuk menandai notifikasi sebagai sudah dibaca. Ketika admin mengklik notifikasi, route ini akan dipanggil
    // dengan ID notifikasi yang ingin ditandai sebagai sudah dibaca. AdminNotificationController akan menang
    Route::get('/notification/{id}/read', [AdminNotificationController::class, 'read'])->name('notification.read');

    // Hutang
    Route::get('/hutang', [HutangController::class, 'index'])->name('hutang.index');
    Route::post('/hutang/{order}/lunaskan', [HutangController::class, 'lunaskan'])->name('hutang.lunaskan');

    // Edit Profile Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
// Akhir Route Admin

// Awal Route Pelanggan
Route::middleware(['auth','pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function ()
{
    // Dashboard
    Route::get('/dashboard', [PelangganDashboard::class, 'index'])->name('dashboard');

    // Order Pelanggan
    Route::get('/order', [PelangganOrder::class, 'index'])->name('order.index');
    Route::get('/order/create', [PelangganOrder::class, 'create'])->name('order.create');
    Route::post('/order', [PelangganOrder::class, 'store'])->name('order.store');
    Route::get('/order/{order}', [PelangganOrder::class, 'show'])->name('order.show');

    // Katalog
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

    // Cart / Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update'); //{cart} adalah parameter yang akan menangkap ID cart yang ingin diupdate. Dengan menggunakan metode PUT, kita mengikuti konvensi RESTful untuk operasi update pada resource cart. Metode ini akan memanggil fungsi update di CartController, yang akan menangani logika untuk memperbarui jumlah item dalam keranjang berdasarkan ID cart yang diberikan.
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // CheckOut
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [CartController::class, 'checkoutStore'])->name('checkout.store');

    // Notifikasi Pelanggan
    // Route untuk menandai notifikasi sebagai sudah dibaca. Ketika pelanggan mengklik notifikasi, route ini akan dipanggil
    // dengan ID notifikasi yang ingin ditandai sebagai sudah dibaca. Setelah itu,
    // pelanggan akan diarahkan ke URL yang terkait dengan notifikasi tersebut (misalnya halaman detail order) atau ke dashboard jika URL tidak tersedia.
    Route::get('/notification/{id}/read', function($id) {
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? route('pelanggan.dashboard'));
        }
        return back();
    })->name('notification.read');

    // Profil Pelanggan
    // Route untuk menampilkan halaman edit profil pelanggan, dengan nama route 'pelanggan.profile.edit'. Halaman ini akan menggunakan metode 'edit' dari Profile
    Route::get('/profile', function() {
        return view('pelanggan.profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');
});
// Akhir Route Pelanggan

// Route untuk mengelola autentikasi (login, register, dll) menggunakan file auth.php yang disediakan oleh Laravel Breeze.
// File ini berisi route yang diperlukan untuk proses autentikasi pengguna, seperti menampilkan form login,
// memproses login, menampilkan form registrasi, memproses registrasi, dan lain sebagainya.
require __DIR__.'/auth.php';
