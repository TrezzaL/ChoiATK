<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <x-sidebar-admin/>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">

            {{-- Top Navbar --}}
            <x-navbar-admin/>

            {{-- Dashboard Content --}}
            <main class="p-6 md:p-8 space-y-8 flex-1 animate-page-load">

                {{-- Welcome Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang Kembali!</h2>
                        <p class="text-sm text-slate-500 mt-1">Halo, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span> — kelola toko ChoiATK kamu hari ini.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400 bg-white border border-slate-100 px-4 py-2.5 rounded-xl shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                    {{-- Card 1: Total Produk --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Produk</p>
                                <p class="text-4xl font-extrabold text-slate-900 mt-2">{{ $totalProduk }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-3 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Item aktif terdaftar
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-100 transition shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.product.index') }}" class="flex items-center gap-1 text-[11px] font-semibold text-blue-600 hover:text-blue-700 mt-4 transition">
                            Lihat Produk
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                    {{-- Card 2: Order Masuk / Pending --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Order Menunggu</p>
                                <p class="text-4xl font-extrabold text-slate-900 mt-2">{{ $orderPending }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full mt-3 border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Perlu diproses segera
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-100 transition shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-amber-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.order.index') }}" class="flex items-center gap-1 text-[11px] font-semibold text-amber-600 hover:text-amber-700 mt-4 transition">
                            Proses Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                    {{-- Card 3: Stok Menipis --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                                <p class="text-4xl font-extrabold text-slate-900 mt-2">{{ $stokMenipis }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full mt-3 border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                    Segera restock
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center group-hover:bg-orange-100 transition shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-orange-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.product.index') }}" class="flex items-center gap-1 text-[11px] font-semibold text-orange-600 hover:text-orange-700 mt-4 transition">
                            Lihat Produk
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                    {{-- Card 4: Stok Habis --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Habis</p>
                                <p class="text-4xl font-extrabold text-slate-900 mt-2">{{ $stokHabis }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full mt-3 border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Tidak tersedia
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center group-hover:bg-red-100 transition shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.product.index') }}" class="flex items-center gap-1 text-[11px] font-semibold text-red-600 hover:text-red-700 mt-4 transition">
                            Tangani Segera
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>

                </div>

                {{-- Bottom 2-column layout: Recent Orders + Quick Actions --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Recent Orders Table (2/3 width) --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm">Pesanan Terbaru</h3>
                            </div>
                            <a href="{{ route('admin.order.index') }}"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                Lihat Semua
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>

                        @if($orderTerbaru->isEmpty())
                            <div class="flex flex-col items-center justify-center py-16 text-center px-6">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada pesanan masuk</p>
                                <p class="text-xs text-slate-400 mt-1">Transaksi pelanggan akan muncul di sini.</p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-50">
                                @foreach($orderTerbaru as $order)
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 transition group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-blue-50 group-hover:bg-blue-100 rounded-xl flex items-center justify-center transition shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $order->user->name }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $order->product->nama }} × {{ $order->jumlah }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-blue-700">{{ $order->totalHargaFormatted() }}</p>
                                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $order->statusColor() }}">
                                            {{ $order->statusLabel() }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Quick Actions Panel (1/3 width) --}}
                    <div class="space-y-5">
                        {{-- Quick Actions Card --}}
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm">Aksi Cepat</h3>
                            </div>

                            <div class="space-y-2.5">
                                <a href="{{ route('admin.product.create') }}"
                                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition group">
                                    <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-800 block">Tambah Produk</span>
                                        <span class="text-[11px] text-slate-400">Daftarkan item baru</span>
                                    </div>
                                </a>

                                <a href="{{ route('admin.category.index') }}"
                                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/30 transition group">
                                    <div class="w-9 h-9 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-800 block">Kelola Kategori</span>
                                        <span class="text-[11px] text-slate-400">Atur pengelompokan item</span>
                                    </div>
                                </a>

                                <a href="{{ route('admin.order.index') }}"
                                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-100 hover:border-amber-200 hover:bg-amber-50/30 transition group">
                                    <div class="w-9 h-9 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-800 block">Proses Order</span>
                                        <span class="text-[11px] text-slate-400">Konfirmasi pesanan masuk</span>
                                    </div>
                                </a>

                                <a href="{{ route('admin.laporan') }}"
                                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-100 hover:border-violet-200 hover:bg-violet-50/30 transition group">
                                    <div class="w-9 h-9 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center group-hover:bg-violet-100 transition shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-800 block">Lihat Laporan</span>
                                        <span class="text-[11px] text-slate-400">Pantau performa toko</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Mini Info Card --}}
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200 mb-2">Info Sistem</p>
                            <p class="text-lg font-extrabold leading-snug">ChoiATK<br>Admin Panel</p>
                            <p class="text-xs text-blue-200 mt-2 leading-relaxed">Pantau dan kelola semua kebutuhan toko ATK kamu dari satu tempat.</p>
                            <a href="{{ route('landing') }}" target="_blank"
                               class="inline-flex items-center gap-1.5 mt-4 text-xs font-bold bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl transition">
                                Buka Landing Page
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html>
