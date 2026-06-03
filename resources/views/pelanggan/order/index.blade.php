<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — ChoiATK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Pesanan Saya</h2>
                        <p class="text-sm text-slate-500 mt-1">Riwayat seluruh pesanan ATK yang pernah kamu buat.</p>
                    </div>
                    <a href="{{ route('pelanggan.katalog') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition self-start sm:self-auto">
                        <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Pesan Lagi
                    </a>
                </div>

                {{-- Toast Sukses --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex items-center gap-3 bg-white border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                        <div class="w-7 h-7 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- BANNER PENGINGAT HUTANG OTOMATIS --}}
                @if(isset($totalHutang) && $totalHutang > 0)
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm shadow-red-100/40">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Catatan Hutang Belum Lunas (Bon)</h3>
                                <p class="text-xs text-slate-500 mt-0.5">Anda memiliki tagihan belanja yang dicatat di buku bon toko. Harap lakukan pelunasan di kasir konter ChoiATK.</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right shrink-0">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Total Tagihan Bon</p>
                            <p class="text-xl font-extrabold text-red-600">Rp {{ number_format($totalHutang, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif

                {{-- FITUR BARU: NAVIGASI FILTER TAB STATUS (Teks Diubah Biar Singkron) --}}
                @php $currentStatus = request('status'); @endphp
                <div class="flex items-center gap-2 overflow-x-auto pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 no-scrollbar">
                    <a href="{{ route('pelanggan.order.index') }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold border transition whitespace-nowrap
                       {{ border_colors_helper('', $currentStatus, 'all') }}">
                        Semua Pesanan
                    </a>
                    <a href="{{ route('pelanggan.order.index', ['status' => 'menunggu konfirmasi']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold border transition whitespace-nowrap
                       {{ border_colors_helper('menunggu konfirmasi', $currentStatus) }}">
                        Menunggu Konfirmasi
                    </a>
                    <a href="{{ route('pelanggan.order.index', ['status' => 'diproses']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold border transition whitespace-nowrap
                       {{ border_colors_helper('diproses', $currentStatus) }}">
                        Siap Diambil / Sedang Diantar
                    </a>
                    <a href="{{ route('pelanggan.order.index', ['status' => 'selesai']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold border transition whitespace-nowrap
                       {{ border_colors_helper('selesai', $currentStatus) }}">
                        Selesai
                    </a>
                    <a href="{{ route('pelanggan.order.index', ['status' => 'ditolak']) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold border transition whitespace-nowrap
                       {{ border_colors_helper('ditolak', $currentStatus) }}">
                        Ditolak
                    </a>
                </div>

                {{-- Orders Section --}}
                @if($orders->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                            <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-slate-700">Tidak ada data transaksi</p>
                        <p class="text-sm text-slate-400 mt-1 mb-6">Tidak ditemukan pesanan dengan status yang kamu pilih.</p>
                        <a href="{{ route('pelanggan.katalog') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition">
                            Lihat Katalog
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($orders as $time => $group)
                            @php
                                $firstOrder = $group->first();
                                $totalHargaGrup = $group->sum('total_harga');
                                $statusConfig = match($firstOrder->status) {
                                    'menunggu konfirmasi' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-100', 'dot' => 'bg-amber-400'],
                                    'diproses'            => ['bg' => 'bg-blue-50 text-blue-700 border-blue-100',     'dot' => 'bg-blue-500'],
                                    'selesai'             => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot' => 'bg-emerald-500'],
                                    'ditolak'             => ['bg' => 'bg-red-50 text-red-600 border-red-100',        'dot' => 'bg-red-500'],
                                    default               => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                                };
                            @endphp

                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                {{-- Order Header --}}
                                <div class="flex justify-between items-center px-6 py-4 border-b border-slate-50 bg-slate-50/40">
                                    <div class="flex flex-wrap items-center gap-3">
                                        {{-- Badge Status Pesanan dengan Masking UX --}}
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $statusConfig['bg'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }} {{ in_array($firstOrder->status, ['menunggu konfirmasi', 'diproses']) ? 'animate-pulse' : '' }}"></span>

                                            {{-- Logika Teks Pembagi Status Diproses --}}
                                            @if($firstOrder->status === 'diproses')
                                                @if(($firstOrder->tipe_penyerahan ?? 'ambil') === 'antar')
                                                    Sedang Dikirim
                                                @else
                                                    Siap Diambil
                                                @endif
                                            @else
                                                {{ $firstOrder->statusLabel() }}
                                            @endif
                                        </span>

                                        {{-- Badge Status Pembayaran (Lunas / Bon / Tunggu) --}}
                                        @if($firstOrder->status === 'selesai')
                                            @if($firstOrder->metode_bayar === 'hutang')
                                                <span class="inline-flex items-center rounded-lg bg-red-50 border border-red-100 px-2.5 py-1 text-xs font-semibold text-red-600">Belum Lunas (Bon)</span>
                                            @else
                                                <span class="inline-flex items-center rounded-lg bg-emerald-50 border border-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-600">Lunas</span>
                                            @endif
                                        @elseif($firstOrder->status === 'ditolak')
                                            <span class="inline-flex items-center rounded-lg bg-slate-100 border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-500">Batal</span>
                                        @else
                                            <span class="inline-flex items-center rounded-lg bg-slate-50 border border-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-400">Menunggu Pelunasan</span>
                                        @endif

                                        <span class="text-xs font-medium text-slate-400">{{ $firstOrder->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                    <a href="{{ route('pelanggan.order.show', $firstOrder) }}"
                                       class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm shadow-blue-500/20">
                                        <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Detail
                                    </a>
                                </div>

                                {{-- Items List --}}
                                <div class="px-6 py-3 divide-y divide-slate-50">
                                    @foreach($group as $item)
                                        <div class="flex justify-between items-center py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 shrink-0">
                                                    @if($item->product->foto)
                                                        <img src="{{ asset('storage/' . $item->product->foto) }}" class="w-full h-full object-cover rounded-xl">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-slate-800 text-sm">{{ $item->product->nama }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5">{{ $item->jumlah }} pcs &times; Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Total Footer --}}
                                <div class="flex justify-between items-center px-6 py-3.5 bg-slate-50/60 border-t border-slate-100">
                                    <span class="text-xs font-semibold text-slate-500">Total Pembayaran</span>
                                    <span class="font-extrabold text-blue-700 text-base">Rp {{ number_format($totalHargaGrup, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </main>
        </div>
    </div>
</body>
</html>

{{-- Helper PHP Ringkas untuk CSS Warna Tab --}}
@php
function border_colors_helper($statusTarget, $currentStatus, $type = 'normal') {
    if ($type === 'all') {
        return is_null($currentStatus)
            ? 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-500/10'
            : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50';
    }
    return $currentStatus === $statusTarget
        ? 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-500/10'
        : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50';
}
@endphp
