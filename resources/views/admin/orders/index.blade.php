<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Order — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <x-sidebar-admin/>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            {{-- Top Navbar --}}
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Filter & Search Panel --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <form method="GET" action="{{ route('admin.order.index') }}" id="filterForm">
                        {{-- Input Hidden Status --}}
                        <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                            {{-- LEFT SIDE: Filter Status & Live Dropdown --}}
                            <div class="flex flex-wrap items-center gap-3 flex-1">
                                <div class="flex items-center gap-2 text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-slate-700">Filter</span>
                                </div>

                                @php
                                    $statuses = [
                                        '' => 'Semua Status',
                                        'menunggu konfirmasi' => 'Menunggu Konfirmasi',
                                        'diproses' => 'Siap Diambil / Diantar', // <--- UBAH BAGIAN INI
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    $currentStatus = request('status') ?? '';
                                @endphp

                                <div x-data="{
                                        open: false,
                                        selectedLabel: '{{ $statuses[$currentStatus] }}',
                                        selectOption(value) {
                                            document.getElementById('statusInput').value = value;
                                            document.getElementById('filterForm').submit();
                                        }
                                    }"
                                    @click.away="open = false"
                                    class="relative inline-block text-left min-w-[200px]">

                                    <button type="button"
                                            @click="open = !open"
                                            class="h-10 w-full pl-4 pr-10 flex items-center justify-between rounded-xl border border-slate-200 text-sm font-medium bg-white hover:border-blue-300 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-slate-700"
                                            :class="open ? 'border-blue-500 ring-4 ring-blue-100' : ''">

                                        <span x-text="selectedLabel"></span>

                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 transition-transform duration-200"
                                              :class="open ? 'rotate-180 text-blue-500' : ''">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </button>

                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                         class="absolute z-30 mt-2 w-full bg-white rounded-xl border border-slate-100 shadow-xl py-1 overflow-hidden focus:outline-none"
                                         style="display: none;">

                                        @foreach($statuses as $value => $label)
                                            <button type="button"
                                                    @click="selectOption('{{ $value }}')"
                                                    class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between
                                                        {{ $currentStatus === $value
                                                            ? 'bg-blue-50 text-blue-700 font-semibold'
                                                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                                <span>{{ $label }}</span>

                                                @if($currentStatus === $value)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT SIDE: BARU! Input Search Pembeli / ID Pesanan (Live Search Alpine.js) --}}
                            <div class="flex items-center gap-2 w-full md:w-auto md:min-w-[280px]" x-data>
                                <div class="relative w-full">
                                    <input type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Cari nama pembeli atau ID order..."
                                        {{-- Trigger Auto-Submit setelah ngetik --}}
                                        @input.debounce.750ms="$el.closest('form').submit()"
                                        {{-- Trik Auto-Focus menjaga kursor di akhir huruf --}}
                                        {{ request('search') ? 'autofocus onfocus="this.setSelectionRange(this.value.length, this.value.length);"' : '' }}
                                        class="w-full h-10 pl-10 pr-4 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-slate-700">

                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                </div>

                                {{-- Tombol Reset (Hanya Muncul Jika Sedang Mencari/Filter) --}}
                                @if(request('status') || request('search'))
                                <a href="{{ route('admin.order.index') }}"
                                class="h-10 px-4 flex items-center justify-center rounded-xl bg-red-50 hover:bg-red-100 text-xs font-bold text-red-600 border border-red-100 transition shrink-0"
                                title="Reset Semua Filter">
                                    Reset
                                </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>

                {{-- Page Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Order</h2>
                        <p class="text-sm text-slate-500 mt-1">Pantau, setujui, dan kelola semua pesanan masuk dari pelanggan ChoiATK.</p>
                    </div>
                    <a href="{{ route('admin.order.create_manual') }}"
                    class="h-12 inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-5 rounded-xl text-sm font-bold shadow-sm transition self-start md:self-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Input Order Offline
                    </a>
                </div>

                {{-- Order Container (Grouped by Date) --}}
                <div class="space-y-4">
                    @forelse($orders as $tanggal => $dailyOrders)
                        @php
                            $groupedTransactions = $dailyOrders->groupBy(function($item) {
                                return $item->user_id . '_' . $item->created_at->format('Y-m-d H:i');
                            });
                            $totalTransaksi = $groupedTransactions->count();
                            $dateObj = \Carbon\Carbon::parse($tanggal)->locale('id');
                        @endphp

                        {{-- Card per Tanggal --}}
                        <div x-data="{ open: true }" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300">

                            {{-- Header Tanggal --}}
                            <button @click="open = !open" class="w-full flex items-center justify-between bg-slate-50/70 hover:bg-slate-50 px-6 py-4 border-b border-slate-100 text-left transition">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-blue-50 text-blue-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 text-sm md:text-base">
                                            {{ $dateObj->translatedFormat('d F Y') }}
                                        </span>
                                        <span class="mx-2 text-slate-300">|</span>
                                        <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full">
                                            {{ $totalTransaksi }} Transaksi
                                        </span>
                                    </div>
                                </div>

                                <div class="text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            {{-- Isi Tabel --}}
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 class="overflow-x-auto">

                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="bg-white border-b border-slate-100 text-sm font-semibold text-slate-600 tracking-tight">
                                            <th class="px-6 py-4">ID</th>
                                            <th class="px-6 py-4">Pelanggan</th>
                                            <th class="px-6 py-4">Produk</th>
                                            <th class="px-6 py-4">Total Harga</th>
                                            <th class="px-6 py-4">Metode</th>
                                            <th class="px-6 py-4">Status</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 text-slate-700">
                                        @foreach($groupedTransactions as $group)
                                            @php
                                                $firstOrder = $group->first();
                                                $daftarProduk = $group->map(function($orderItem) {
                                                    return $orderItem->product->nama . ' (' . $orderItem->jumlah . 'x)';
                                                })->implode(', ');

                                                $totalHargaGrup = $group->sum('total_harga');

                                                $statusConfig = match($firstOrder->status) {
                                                    'menunggu konfirmasi' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-100', 'dot' => 'bg-amber-400'],
                                                    'diproses' => ['bg' => 'bg-blue-50 text-blue-700 border-blue-100', 'dot' => 'bg-blue-500'],
                                                    'selesai' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'dot' => 'bg-emerald-500'],
                                                    'ditolak' => ['bg' => 'bg-red-50 text-red-600 border-red-100', 'dot' => 'bg-red-500'],
                                                    default => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                                                };
                                            @endphp

                                            <tr class="hover:bg-slate-50/80 transition">
                                                <td class="px-6 py-4">
                                                    <span class="font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg text-xs">
                                                        #{{ $firstOrder->id }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 font-medium text-slate-900">
                                                    {{ $firstOrder->user->name }}
                                                </td>
                                                <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $daftarProduk }}">
                                                    {{ $daftarProduk }}
                                                </td>
                                                <td class="px-6 py-4 font-semibold text-slate-900">
                                                    Rp {{ number_format($totalHargaGrup,0,',','.') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">
                                                        {{ $firstOrder->metode_bayar ?? 'CASH' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $statusConfig['bg'] }}">
                                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }} {{ in_array($firstOrder->status, ['menunggu konfirmasi', 'diproses']) ? 'animate-pulse' : '' }}"></span>

                                                        {{-- Trik UI Masking untuk Admin --}}
                                                        @if($firstOrder->status === 'diproses')
                                                            @if(($firstOrder->tipe_penyerahan ?? 'ambil') === 'antar')
                                                                Sedang Diantar
                                                            @else
                                                                Siap Diambil
                                                            @endif
                                                        @else
                                                            {{ $firstOrder->statusLabel() }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <a href="{{ route('admin.order.show', $firstOrder->id) }}" class="inline-flex items-center gap-1.5 text-xs bg-blue-50 hover:bg-blue-100 text-blue-700 px-3.5 py-1.5 rounded-xl font-bold border border-blue-100 transition">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <h3 class="text-slate-700 font-bold mb-1">Tidak Ada Pesanan</h3>
                            <p class="text-sm text-slate-400">Belum ada data transaksi masuk untuk kriteria saat ini.</p>
                        </div>
                    @endforelse
                </div>

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
