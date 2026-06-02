<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6">

                {{-- Hero Greeting --}}
                <div class="relative bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-7 overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                    <div class="absolute bottom-0 left-12 w-28 h-28 bg-white/5 rounded-full translate-y-1/2"></div>
                    <div class="relative z-10">
                        <p class="text-blue-200 text-sm font-medium">Selamat datang kembali</p>
                        <h2 class="text-2xl font-extrabold text-white mt-1 tracking-tight">{{ auth()->user()->name }}</h2>
                        <p class="text-blue-200 text-sm mt-2">Temukan kebutuhan alat tulis kantor terbaik untuk kamu.</p>
                        <div class="flex gap-3 mt-5">
                            <a href="{{ route('pelanggan.katalog') }}"
                               class="inline-flex items-center gap-2 bg-white text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-900/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35" />
                                </svg>
                                Belanja Sekarang
                            </a>
                            <a href="{{ route('pelanggan.order.index') }}"
                               class="inline-flex items-center gap-2 bg-blue-500/30 hover:bg-blue-500/50 text-white px-5 py-2.5 rounded-xl text-sm font-bold border border-blue-400/30 transition">
                                Pesanan Saya
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5">

                    {{-- Total Order --}}
                    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        <div class="absolute inset-y-0 left-0 w-1.5 bg-blue-500 rounded-l-2xl"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100 pointer-events-none"></div>

                        <div class="relative flex justify-between items-center">
                            <div class="flex flex-col">
                                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-1.5">Total Order</p>
                                <p class="text-3xl font-black text-slate-900 tabular-nums leading-none">{{ $totalOrder }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-50/80 rounded-xl flex items-center justify-center group-hover:bg-white transition-colors duration-300 shadow-inner group-hover:shadow-sm border border-transparent group-hover:border-blue-100 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Menunggu --}}
                    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        <div class="absolute inset-y-0 left-0 w-1.5 bg-amber-400 rounded-l-2xl"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-amber-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100 pointer-events-none"></div>

                        <div class="relative flex justify-between items-center">
                            <div class="flex flex-col">
                                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-1.5">Menunggu</p>
                                <p class="text-3xl font-black text-slate-900 tabular-nums leading-none">{{ $menungguKonfirmasi }}</p>
                            </div>
                            <div class="w-12 h-12 bg-amber-50/80 rounded-xl flex items-center justify-center group-hover:bg-white transition-colors duration-300 shadow-inner group-hover:shadow-sm border border-transparent group-hover:border-amber-100 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-amber-500 group-hover:scale-110 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Diproses --}}
                    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        <div class="absolute inset-y-0 left-0 w-1.5 bg-indigo-500 rounded-l-2xl"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-indigo-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100 pointer-events-none"></div>

                        <div class="relative flex justify-between items-center">
                            <div class="flex flex-col">
                                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-1.5">Diproses</p>
                                <p class="text-3xl font-black text-slate-900 tabular-nums leading-none">{{ $diproses }}</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-50/80 rounded-xl flex items-center justify-center group-hover:bg-white transition-colors duration-300 shadow-inner group-hover:shadow-sm border border-transparent group-hover:border-indigo-100 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Selesai --}}
                    <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        <div class="absolute inset-y-0 left-0 w-1.5 bg-emerald-500 rounded-l-2xl"></div>
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-emerald-50 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 scale-50 group-hover:scale-100 pointer-events-none"></div>

                        <div class="relative flex justify-between items-center">
                            <div class="flex flex-col">
                                <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-1.5">Selesai</p>
                                <p class="text-3xl font-black text-slate-900 tabular-nums leading-none">{{ $selesai }}</p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-50/80 rounded-xl flex items-center justify-center group-hover:bg-white transition-colors duration-300 shadow-inner group-hover:shadow-sm border border-transparent group-hover:border-emerald-100 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('pelanggan.katalog') }}"
                        class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-blue-600 rounded-xl flex items-center justify-center transition-colors shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Lihat Katalog ATK</p>
                            <p class="text-xs text-slate-400 mt-0.5">Browse produk alat tulis terlengkap</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-slate-300 group-hover:text-blue-500 transition-colors shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    <a href="{{ route('pelanggan.order.index') }}"
                        class="group bg-white rounded-2xl border border-slate-100 p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-200 flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 group-hover:bg-amber-500 rounded-xl flex items-center justify-center transition-colors shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Pesanan Saya</p>
                            <p class="text-xs text-slate-400 mt-0.5">Lihat status & riwayat order</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-slate-300 group-hover:text-blue-500 transition-colors shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                {{-- Recent Orders --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900 text-sm">Pesanan Terakhir</h3>
                        <a href="{{ route('pelanggan.order.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition">Lihat Semua →</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($recentOrders as $order)
                            <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50/50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">Pesanan #{{ $order->id }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                @php
                                    $sConfig = match($order->status) {
                                        'menunggu konfirmasi' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'diproses' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'ditolak' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-xl text-xs font-semibold border {{ $sConfig }}">
                                    {{ $order->statusLabel() }}
                                </span>
                            </div>
                        @empty
                            <div class="py-14 text-center">
                                <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-slate-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-sm text-slate-400">Belum ada pesanan. <a href="{{ route('pelanggan.katalog') }}" class="text-blue-600 font-semibold hover:underline">Mulai belanja</a>!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
