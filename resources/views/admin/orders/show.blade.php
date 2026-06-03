<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan — Panel Admin ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <a href="{{ route('admin.order.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali ke Daftar Order
                        </a>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Pesanan Kelompok <span class="text-blue-600">#{{ $order->id }}</span></h2>
                    </div>

                    {{-- Status Badge (DIPERBAIKI DENGAN UI MASKING) --}}
                    @php
                        $statusConfig = match($order->status) {
                            'menunggu konfirmasi' => ['class' => 'bg-amber-50 text-amber-700 border-amber-200',  'dot' => 'bg-amber-400'],
                            'diproses'            => ['class' => 'bg-blue-50 text-blue-700 border-blue-200',     'dot' => 'bg-blue-500'],
                            'selesai'             => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
                            'ditolak'             => ['class' => 'bg-red-50 text-red-600 border-red-200',        'dot' => 'bg-red-500'],
                            default               => ['class' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                        };
                    @endphp
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border {{ $statusConfig['class'] }} self-start sm:self-auto shadow-sm">
                        <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }} {{ in_array($order->status, ['menunggu konfirmasi', 'diproses']) ? 'animate-pulse' : '' }}"></span>

                        {{-- Logika Masking --}}
                        @if($order->status === 'diproses')
                            @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                Sedang Diantar
                            @else
                                Siap Diambil
                            @endif
                        @else
                            {{ $order->statusLabel() }}
                        @endif
                    </span>
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                         class="flex items-center gap-3 bg-white border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-white border border-red-100 text-red-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Main Content Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                    {{-- LEFT: List Seluruh Produk yang Dibeli --}}
                    <div class="lg:col-span-2 space-y-5">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Item yang Dibeli ({{ $groupedOrders->count() }} produk)</h3>
                            </div>

                            {{-- LOOPING PERBAIKAN: Menampilkan seluruh produk yang masuk checkout bareng --}}
                            <div class="divide-y divide-slate-50">
                                @foreach($groupedOrders as $itemOrder)
                                    <div class="flex items-center gap-4 px-6 py-5 hover:bg-slate-50/40 transition">
                                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0">
                                            @if($itemOrder->product->foto)
                                                <img src="{{ asset('storage/' . $itemOrder->product->foto) }}" class="w-full h-full object-cover">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-slate-300">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-slate-800 text-sm truncate">{{ $itemOrder->product->nama }}</h4>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                {{ $itemOrder->product->category->nama ?? 'ATK' }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                                                <span>{{ $itemOrder->jumlah }} pcs</span>
                                                <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                                <span>&times; Rp {{ number_format($itemOrder->product->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <span class="text-sm font-extrabold text-slate-900 shrink-0">
                                            Rp {{ number_format($itemOrder->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Catatan & Alamat Pembeli --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Catatan & Lokasi Alamat Kirim</h3>
                            </div>
                            <div class="p-6">
                                @if($order->catatan)
                                    <p class="text-sm text-slate-700 bg-slate-50 p-4 rounded-xl border border-slate-100 font-medium leading-relaxed">
                                        {{ $order->catatan }}
                                    </p>
                                @else
                                    <p class="text-sm text-slate-400 italic">Tidak ada catatan alamat dari pembeli.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: Ringkasan Seluruh Transaksi Kelompok --}}
                    <div class="space-y-5">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Data Transaksi</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Nama Pemesan</span>
                                    <span class="font-bold text-slate-800 text-sm">{{ $order->user->name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">No. Telepon</span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $order->user->phone ?? '—' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Penyerahan</span>
                                    <span class="font-bold text-xs px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase">
                                        {{ $order->tipe_penyerahan == 'antar' ? 'Diantar Kurir' : 'Ambil Sendiri' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Metode Bayar</span>
                                    <span class="font-bold text-xs px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 uppercase border border-slate-200">{{ $order->metode_bayar }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-slate-400">Waktu Order</span>
                                    <span class="text-slate-500 text-xs font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="border-t border-dashed border-slate-100 pt-4 flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-900">Total Belanja</span>
                                    <span class="text-xl font-extrabold text-blue-700">Rp {{ number_format($grandTotalGroup, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION PANEL ADMIN --}}
                        @if($order->status === 'menunggu konfirmasi')
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ showRejectForm: false }">
                                <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                    <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">Konfirmasi Pesanan</h3>
                                </div>
                                <div class="p-5 space-y-3">
                                    <p class="text-xs text-slate-400 leading-relaxed">Tinjau daftar produk keranjang di atas, lalu setujui atau tolak seluruh pesanan ini.</p>

                                    {{-- Container Utama Modal Konfirmasi Setujui dengan Alpine.js --}}
                                    <div x-data="{ openConfirmModal: false }">

                                        {{-- 1. Tombol Pemicu Utama (Yang diklik Admin di halaman order) --}}
                                        <button type="button"
                                                @click="openConfirmModal = true"
                                                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-2">
                                            Setujui & Proses
                                        </button>

                                        {{-- 2. Pop-up Modal Konfirmasi Premium --}}
                                        <div x-show="openConfirmModal"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                                            style="display: none;">

                                            {{-- Kotak Putih Modal --}}
                                            <div @click.away="openConfirmModal = false"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-xl space-y-4 text-left">

                                                {{-- Konten Informasi (Tema Warna Biru untuk Aksi Konfirmasi/Proses) --}}
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-base font-bold text-slate-900">Konfirmasi Proses</h3>
                                                        <p class="text-xs text-slate-400 mt-0.5">Setujui & proses semua pesanan dalam keranjang ini?</p>
                                                    </div>
                                                </div>

                                                {{-- Tombol Pilihan Pilihan Aksi --}}
                                                <div class="grid grid-cols-2 gap-3 pt-2">
                                                    {{-- Tombol Batal --}}
                                                    <button type="button"
                                                            @click="openConfirmModal = false"
                                                            class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                        Batal
                                                    </button>

                                                    {{-- Form Native PATCH Laravel (Hanya berjalan jika admin klik tombol biru ini) --}}
                                                    <form action="{{ route('admin.order.confirm', $order->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                                class="w-full h-10 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition rounded-xl shadow-md shadow-blue-500/10">
                                                            Ya, Setujui
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tolak Toggle --}}
                                    <button @click="showRejectForm = !showRejectForm"
                                        class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-bold border border-red-100 transition flex items-center justify-center gap-2">
                                        <span x-text="showRejectForm ? 'Batalkan' : 'Tolak Pesanan'"></span>
                                    </button>

                                    {{-- Reject Form --}}
                                    <div x-show="showRejectForm" x-transition class="bg-red-50 rounded-xl border border-red-100 p-4 space-y-3" style="display:none;">
                                        <form action="{{ route('admin.order.reject', $order->id) }}" method="POST" class="space-y-3">
                                            @csrf @method('PATCH')
                                            <div>
                                                <label class="block text-xs font-bold text-red-700 uppercase tracking-wider mb-1.5">Alasan Penolakan</label>
                                                <input type="text" name="alasan_tolak" required placeholder="Contoh: Stok habis, diluar radius..."
                                                    class="w-full px-3.5 py-2.5 border border-red-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                                            </div>
                                            <button type="submit" class="w-full py-2.5 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition">
                                                Kirim & Tolak Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @elseif($order->status === 'diproses')
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">Proses Penyerahan</h3>
                                </div>
                                <div class="p-5 space-y-3">
                                    {{-- Kalimat instruksi admin (DIPERBAIKI DENGAN LOGIKA TIPE PENYERAHAN) --}}
                                    @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                        <p class="text-xs text-slate-500 leading-relaxed bg-blue-50 p-3 rounded-xl border border-blue-100">
                                            🚚 Barang sedang <strong class="text-blue-700">diantar kurir</strong> ke alamat pembeli. Klik tombol di bawah jika barang fisik sudah diterima.
                                        </p>
                                    @else
                                        <p class="text-xs text-slate-500 leading-relaxed bg-blue-50 p-3 rounded-xl border border-blue-100">
                                            🛍️ Barang <strong class="text-blue-700">siap diambil</strong> di toko. Klik tombol di bawah jika pelanggan sudah mengambil pesanannya.
                                        </p>
                                    @endif

                                    {{-- Container Utama Modal Konfirmasi Selesai dengan Alpine.js --}}
                                    <div x-data="{ openCompleteModal: false }">

                                        {{-- 1. Tombol Pemicu Utama (Yang tampil di layar dashboard admin) --}}
                                        <button type="button"
                                                @click="openCompleteModal = true"
                                                class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-md shadow-emerald-500/20 transition flex items-center justify-center gap-2 mt-2">
                                            Selesaikan Pesanan
                                        </button>

                                        {{-- 2. Pop-up Modal Konfirmasi Berwarna Tema Emerald Sukses --}}
                                        <div x-show="openCompleteModal"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                                            style="display: none;">

                                            {{-- Kotak Putih Modal --}}
                                            <div @click.away="openCompleteModal = false"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-xl space-y-4 text-left">

                                                {{-- Konten Informasi (Tema Warna Hijau Emerald untuk Penanda Sukses) --}}
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-base font-bold text-slate-900">Selesaikan Pesanan</h3>
                                                        <p class="text-xs text-slate-400 mt-0.5">Yakin ingin menyelesaikan pesanan kelompok ini? Transaksi akan langsung tercatat di laporan keuangan.</p>
                                                    </div>
                                                </div>

                                                {{-- Tombol Pilihan Aksi --}}
                                                <div class="grid grid-cols-2 gap-3 pt-2">
                                                    {{-- Tombol Batal --}}
                                                    <button type="button"
                                                            @click="openCompleteModal = false"
                                                            class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                        Batal
                                                    </button>

                                                    {{-- Form PATCH Laravel Asli --}}
                                                    <form action="{{ route('admin.order.complete', $order->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                                class="w-full h-10 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition rounded-xl shadow-md shadow-emerald-500/10">
                                                            Ya, Selesai
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Riwayat Akhir (DIPERBAIKI DENGAN UI MASKING) --}}
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Akhir</p>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-bold border {{ $statusConfig['class'] }}">
                                    @if($order->status === 'diproses')
                                        @if(($order->tipe_penyerahan ?? 'ambil') === 'antar')
                                            Sedang Diantar
                                        @else
                                            Siap Diambil
                                        @endif
                                    @else
                                        {{ $order->statusLabel() }}
                                    @endif
                                </span>
                                @if($order->status === 'ditolak' && $order->alasan_tolak)
                                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100 text-left">
                                        <p class="text-xs text-red-700 italic">"{{ $order->alasan_tolak }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
