<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <a href="{{ route('pelanggan.order.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali ke Pesanan
                        </a>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Pesanan <span class="text-blue-600">#{{ $order->id }}</span></h2>
                    </div>

                    @php
                        $sConfig = match($order->status) {
                            'menunggu konfirmasi' => ['class' => 'bg-amber-50 text-amber-700 border-amber-200', 'dot' => 'bg-amber-400'],
                            'diproses'           => ['class' => 'bg-blue-50 text-blue-700 border-blue-200',     'dot' => 'bg-blue-500'],
                            'selsung'            => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
                            'selesai'            => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
                            'ditolak'            => ['class' => 'bg-red-50 text-red-600 border-red-200',        'dot' => 'bg-red-500'],
                            default              => ['class' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                        };
                    @endphp
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border {{ $sConfig['class'] }} self-start sm:self-auto shadow-sm">
                        <span class="w-2 h-2 rounded-full {{ $sConfig['dot'] }} {{ in_array($order->status, ['menunggu konfirmasi', 'diproses']) ? 'animate-pulse' : '' }}"></span>

                        {{-- Trik UI Masking: Ubah Label Tampilan Saja --}}
                        @if($order->status === 'diproses')
                            @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                Sedang Dikirim 🚚
                            @else
                                Siap Diambil 🛍️
                            @endif
                        @else
                            {{ $order->statusLabel() }}
                        @endif
                    </span>
                </div>

                {{-- Main Content Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                    {{-- LEFT: Product Detail --}}
                    <div class="lg:col-span-2 space-y-5">

                        {{-- Product Card --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Produk yang Dipesan</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                                        @if($order->product->foto)
                                            <img src="{{ asset('storage/' . $order->product->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-slate-900 text-lg leading-tight">{{ $order->product->nama }}</h4>
                                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                                            {{ $order->product->category->nama ?? 'ATK' }}
                                        </span>
                                        <div class="flex items-center gap-5 mt-4">
                                            <div>
                                                <p class="text-xs font-semibold text-slate-400 mb-0.5">Harga / pcs</p>
                                                <p class="text-sm font-bold text-slate-800">{{ $order->product->hargaFormatted() }}</p>
                                            </div>
                                            <div class="w-px h-8 bg-slate-100"></div>
                                            <div>
                                                <p class="text-xs font-semibold text-slate-400 mb-0.5">Jumlah</p>
                                                <p class="text-sm font-bold text-slate-800">{{ $order->jumlah }} pcs</p>
                                            </div>
                                            <div class="w-px h-8 bg-slate-100"></div>
                                            <div>
                                                <p class="text-xs font-semibold text-slate-400 mb-0.5">Total</p>
                                                <p class="text-base font-extrabold text-blue-700">{{ $order->totalhargaFormatted() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan / Detail Alamat Rumah --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Metode Penyerahan Barang</p>
                                <span class="inline-flex items-center gap-1.5 font-bold text-sm text-slate-800">
                                    @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.317-5.077a1.125 1.125 0 00-1.124-1.049H18l-1.5-4.5A1.125 1.125 0 0015.425 3H10.5m5.5 12.75a1.5 1.5 0 11-3 0M4.5 10.5h11.25" />
                                        </svg>
                                        Diantar oleh Kurir Toko ChoiATK
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-indigo-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18M12 2.25l9.155 7.121a.75.75 0 01-.465 1.301H2.31a.75.75 0 01-.465-1.301L12 2.25z" />
                                        </svg>
                                        Ambil Sendiri di Konter Fisik Toko
                                    @endif
                                </span>
                            </div>

                            @if($order->catatan)
                                <div class="border-t border-slate-50 pt-3">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan / Alamat Pengiriman</p>
                                    <p class="text-sm text-slate-700 bg-slate-50 p-4 rounded-xl border border-slate-100 italic leading-relaxed">
                                        "{{ $order->catatan }}"
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Alasan Ditolak --}}
                        @if($order->alasan_tolak)
                        <div class="bg-red-50 rounded-2xl border border-red-100 p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <p class="text-xs font-bold text-red-700 uppercase tracking-widest">Alasan Ditolak</p>
                            </div>
                            <p class="text-sm text-red-700 italic">"{{ $order->alasan_tolak }}"</p>
                        </div>
                        @endif

                    </div>

                    {{-- RIGHT: Transaction Info + INSTANT STATUS ACTIONS --}}
                    <div class="space-y-5">

                        {{-- Status Banner Interaktif Ditaruh Paling Atas Sisi Kanan --}}
                        @if($order->status === 'menunggu konfirmasi')
                            {{-- 1. Status: Menunggu Konfirmasi --}}
                            <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 shadow-sm ring-2 ring-amber-500/10">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0 text-amber-600 shadow-sm animate-bounce">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-extrabold text-amber-900">Menunggu Tinjauan</h4>
                                        <p class="text-xs text-amber-700 mt-1 leading-relaxed font-medium">Pesananmu sedang diperiksa oleh admin toko. Mohon tunggu sebentar, halaman ini akan diperbarui otomatis.</p>
                                    </div>
                                </div>
                            </div>

                        @elseif($order->status === 'diproses')
                            {{-- 2. Status: Diproses (Logika Teks Terbelah Berdasarkan Cara Penyerahan) --}}
                            <div class="bg-blue-600 rounded-2xl p-5 text-white shadow-lg shadow-blue-500/20 ring-4 ring-blue-600/10 relative overflow-hidden">
                                {{-- Dekorasi background --}}
                                <div class="absolute -right-6 -bottom-6 text-blue-500/30 pointer-events-none transform -rotate-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-32 h-32">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>

                                <div class="flex items-start gap-3.5 relative z-10">
                                    @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                        {{-- Animasi Truck Bergerak untuk Layanan Pengantaran --}}
                                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center shrink-0 text-white shadow-inner animate-pulse">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.317-5.077a1.125 1.125 0 00-1.124-1.049H18l-1.5-4.5A1.125 1.125 0 0015.425 3H10.5m5.5 12.75a1.5 1.5 0 11-3 0M4.5 10.5h11.25" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-extrabold uppercase tracking-wide text-blue-50">Pesanan Sedang Diantar</h4>
                                            <p class="text-xs text-white/90 mt-1.5 font-medium leading-relaxed">Pesanan Anda sudah dikonfirmasi admin dan **sedang dalam perjalanan menuju alamat rumah Anda** bersama kurir ChoiATK!</p>
                                        </div>
                                    @else
                                        {{-- Animasi Store untuk Layanan Ambil Sendiri --}}
                                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center shrink-0 text-white shadow-inner animate-bounce">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18M12 2.25l9.155 7.121a.75.75 0 01-.465 1.301H2.31a.75.75 0 01-.465-1.301L12 2.25z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-extrabold uppercase tracking-wide text-blue-50">Siap Diambil di Toko</h4>
                                            <p class="text-xs text-white/90 mt-1.5 font-semibold leading-relaxed bg-blue-700/40 p-3 rounded-xl border border-white/10 shadow-inner">
                                                🚀 Barang sudah selesai disiapkan! Silakan langsung datang ke konter fisik ChoiATK untuk mengambil belanjaan Anda.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        @elseif($order->status === 'selesai')
                            {{-- 3. Status: Pesanan Selesai --}}
                            <div class="bg-emerald-50 rounded-2xl border border-emerald-200 p-5 shadow-sm ring-2 ring-emerald-500/10">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0 text-emerald-600 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-extrabold text-emerald-900">Transaksi Selesai</h4>
                                        <p class="text-xs text-emerald-700 mt-1 leading-relaxed font-medium">Pesananmu telah diserahterimakan dengan sukses. Terima kasih banyak sudah berbelanja di ChoiATK! 🎉</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Ringkasan Transaksi --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Ringkasan Transaksi</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Metode Bayar</span>
                                    <span class="font-bold text-xs px-2.5 py-1 rounded-lg uppercase tracking-wide border
                                        {{ $order->metode_bayar == 'cash' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }}">
                                        {{ $order->metode_bayar == 'cash' ? 'Cash / Tunai' : 'Hutang / Bon' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Tanggal Order</span>
                                    <span class="text-slate-700 text-xs font-medium">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <div class="border-t border-dashed border-slate-100 pt-4 flex justify-between items-center">
                                    <span class="font-bold text-slate-900 text-sm">Total Bayar</span>
                                    <span class="text-lg font-extrabold text-blue-700">{{ $order->totalhargaFormatted() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Order Again CTA --}}
                        <a href="{{ route('pelanggan.katalog') }}"
                           class="flex items-center justify-center gap-2 w-full py-3.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl text-sm font-bold border border-blue-200 shadow-sm transition active:scale-[0.99]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                            Kembali Belanja ATK
                        </a>
                    </div>

                </div>

            </main>
        </div>
    </div>
</body>
</html>
