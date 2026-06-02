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

Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', function () {
    $categories = Category::all();
    $products = Product::where('is_aktif', true)->with('category')->get();
    return view('landing', compact('categories', 'products'));
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
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

    // Pindahkan MANUAL ke atas agar tidak tertabrak parameter {order}
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
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // CheckOut
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/store', [CartController::class, 'checkoutStore'])->name('checkout.store');

    // Notifikasi Pelanggan
    Route::get('/notification/{id}/read', function($id) {
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? route('pelanggan.dashboard'));
        }
        return back();
    })->name('notification.read');

    // Profil Pelanggan
    Route::get('/profile', function() {
        return view('pelanggan.profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');
});
// Akhir Route Pelanggan

require __DIR__.'/auth.php';
