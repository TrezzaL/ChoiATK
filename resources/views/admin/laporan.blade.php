<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Toko — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-8">

                {{-- Page Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                {{-- Judul --}}
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Laporan Toko
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Pantau performa penjualan dan statistik produk ChoiATK.
                    </p>
                </div>

                {{-- Action Area --}}
                <div class="flex items-center gap-3">

                    {{-- Filter --}}
                    <form method="GET" x-data="{ open: false }">
                        <div class="relative">
                            {{-- Button --}}
                            <button
                                type="button"
                                @click="open = !open"
                                class="
                                    h-12 min-w-[190px]

                                    flex items-center justify-between

                                    px-4

                                    bg-white
                                    border border-slate-200
                                    rounded-xl

                                    text-sm font-medium text-slate-700

                                    shadow-sm

                                    hover:border-blue-400
                                    hover:shadow-md

                                    active:scale-[0.98]

                                    transition-all duration-200
                                "
                            >
                                <span>
                                    @if(request('filter') == 'bulan')
                                        30 Hari Terakhir
                                    @else
                                        Semua Data
                                    @endif
                                </span>

                                <svg
                                    class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div
                                x-show="open"
                                @click.outside="open = false"

                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"

                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"

                                class="
                                    absolute
                                    z-50
                                    mt-2
                                    w-full

                                    bg-white
                                    border border-slate-200
                                    rounded-xl

                                    shadow-xl

                                    overflow-hidden
                                "
                                style="display:none;"
                            >

                                {{-- Semua Data --}}
                                <button
                                    type="submit"
                                    name="filter"
                                    value="all"
                                    class="
                                        w-full
                                        text-left

                                        px-4 py-3

                                        text-sm
                                        text-slate-700

                                        hover:bg-blue-50
                                        hover:text-blue-700

                                        transition
                                    "
                                >
                                    Semua Data
                                </button>

                                {{-- 30 Hari --}}
                                <button
                                    type="submit"
                                    name="filter"
                                    value="bulan"
                                    class="
                                        w-full
                                        text-left

                                        px-4 py-3

                                        text-sm
                                        text-slate-700

                                        hover:bg-blue-50
                                        hover:text-blue-700

                                        transition
                                    "
                                >
                                    30 Hari Terakhir
                                </button>

                            </div>

                        </div>

                    </form>

                    {{-- Export PDF --}}
                    <a href="{{ route('admin.laporan.pdf') }}"
                    class="
                            group
                            inline-flex
                            items-center
                            gap-2

                            px-5 py-3

                            rounded-2xl

                            bg-gradient-to-r
                            from-red-600
                            to-red-700

                            text-white
                            font-semibold

                            shadow-lg
                            shadow-red-500/20

                            hover:shadow-xl
                            hover:shadow-red-500/30
                            hover:-translate-y-0.5

                            active:scale-95

                            transition-all
                            duration-200
                    ">

                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5 transition-transform duration-200 group-hover:-translate-y-0.5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v4.125c0 .621-.504 1.125-1.125 1.125H5.625A1.125 1.125 0 014.5 18.375V5.625C4.5 5.004 5.004 4.5 5.625 4.5H12m0 0l3 3m-3-3v3h3m-3 6h6"/>
                        </svg>

                        <span>Export PDF</span>

                        <span class="px-2 py-0.5 text-[10px] rounded-full bg-white/20">
                            PDF
                        </span>

                    </a>

                </div>

            </div>

                {{-- Stats Summary Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                    {{-- Total Pendapatan --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pendapatan</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400 mt-2">dari order yang selesai</p>
                    </div>

                    {{-- Order Selesai --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:bg-emerald-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Order Selesai</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalOrderSelesai }}</p>
                        <p class="text-xs text-slate-400 mt-2">transaksi berhasil</p>
                    </div>

                    {{-- Order Menunggu --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-amber-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menunggu Konfirmasi</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalOrderPending }}</p>
                        <p class="text-xs text-slate-400 mt-2">perlu dikonfirmasi</p>
                    </div>

                    {{-- Order Ditolak --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 bg-red-50 rounded-2xl flex items-center justify-center group-hover:bg-red-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ditolak</p>
                        <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalOrderDitolak }}</p>
                        <p class="text-xs text-slate-400 mt-2">order tidak diproses</p>
                    </div>

                </div>

                {{-- Two Column: Terlaris & Jarang Dibeli --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Produk Terlaris --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-amber-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Produk Terlaris</h3>
                                <p class="text-xs text-slate-400">Berdasarkan jumlah order selesai</p>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($terlaris->isEmpty() || $terlaris->first()->orders_count == 0)
                                <div class="text-center py-8">
                                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-400">Belum ada data penjualan</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($terlaris as $index => $product)
                                        @if($product->orders_count > 0)
                                        <div class="flex items-center gap-4">
                                            {{-- Rank Badge --}}
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-extrabold shrink-0
                                                {{ $index === 0 ? 'bg-yellow-400 text-yellow-900 shadow-md shadow-yellow-400/30' :
                                                   ($index === 1 ? 'bg-slate-300 text-slate-700' :
                                                   ($index === 2 ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-500')) }}">
                                                {{ $index + 1 }}
                                            </div>

                                            {{-- Product Info --}}
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $product->nama }}</p>
                                                <p class="text-xs text-slate-400 mt-0.5">{{ $product->category->nama }}</p>
                                            </div>

                                            {{-- Sales Count --}}
                                            <div class="text-right shrink-0">
                                                <span class="text-sm font-extrabold text-blue-700">{{ $product->total_terjual }} pcs</span>
                                                <p class="text-[10px] text-slate-400">terjual</p>
                                            </div>
                                        </div>

                                        {{-- Progress Bar --}}
                                        @if($terlaris->first()->orders_count > 0)
                                            @php $pct = $terlaris->first()->total_terjual > 0 ? round(($product->total_terjual / $terlaris->first()->total_terjual) * 100) : 0; @endphp
                                            <div class="h-1 bg-slate-100 rounded-full -mt-2 overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-700
                                                    {{ $index === 0 ? 'bg-yellow-400' : ($index === 1 ? 'bg-slate-400' : ($index === 2 ? 'bg-amber-600' : 'bg-blue-300')) }}"
                                                    style="width: {{ $pct }}%"></div>
                                            </div>
                                        @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Produk Kurang Laku --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-red-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Produk Kurang Laku</h3>
                                <p class="text-xs text-slate-400">Perlu strategi promosi lebih</p>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($jarangDibeli->isEmpty())
                                <div class="text-center py-8">
                                    <p class="text-sm text-slate-400">Semua produk terjual dengan baik!</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($jarangDibeli as $product)
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-red-50/40 border border-transparent hover:border-red-100 transition group">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 bg-red-50 group-hover:bg-red-100 rounded-xl flex items-center justify-center shrink-0 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-red-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-slate-800 truncate">{{ $product->nama }}</p>
                                                <p class="text-xs text-slate-400">{{ $product->category->nama }}</p>
                                            </div>
                                        </div>
                                        <span class="text-sm font-extrabold text-red-500 shrink-0 ml-3">{{ $product->total_terjual }} pcs</span>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Produk Belum Pernah Diorder --}}
                @if($belumDiorder->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                        <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Belum Pernah Diorder</h3>
                            <p class="text-xs text-slate-400">{{ $belumDiorder->count() }} produk tanpa riwayat transaksi</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            @foreach($belumDiorder as $product)
                            <div class="bg-slate-50 hover:bg-slate-100 rounded-xl p-4 border border-slate-100 hover:border-slate-200 transition group cursor-default">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center border border-slate-200 mb-3 group-hover:border-slate-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 leading-snug">{{ $product->nama }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ $product->category->nama }}</p>
                                <p class="text-xs font-bold text-blue-600 mt-2">{{ $product->hargaFormatted() }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </main>
        </div>
    </div>
</body>
</html>
