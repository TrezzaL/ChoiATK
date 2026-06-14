<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk ATK — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto min-h-screen">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Page Header --}}
                <div
                    x-data="{
                        open:false,
                        selected:'{{ request('filter') == 'habis'
                            ? 'Stok Habis'
                            : (request('filter') == 'menipis'
                                ? 'Stok Menipis'
                                : 'Semua Produk') }}'
                    }"
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3"
                >
                    <form method="GET" class="flex flex-col md:flex-row items-center gap-2">

                        {{-- Live Search Input --}}
                        <div class="relative flex-1 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari produk..."
                                {{-- Trigger Auto-Submit setelah berhenti ngetik 0.75 detik --}}
                                @input.debounce.750ms="$el.closest('form').submit()"
                                {{-- Trik Auto-Focus agar kursor lanjut berkedip tanpa ngulang dari depan --}}
                                {{ request('search') ? 'autofocus onfocus="this.setSelectionRange(this.value.length, this.value.length);"' : '' }}
                                class="w-full h-10 pl-9 pr-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all"
                            >
                        </div>

                        {{-- Custom Dropdown Auto-Submit --}}
                        <div class="relative w-full md:w-auto">
                            <input type="hidden" name="filter" value="{{ request('filter') }}" x-ref="filterInput">

                            <button
                                type="button"
                                @click="open = !open"
                                class="h-10 min-w-[170px] px-4 flex items-center justify-between gap-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 shadow-sm hover:border-blue-300 hover:shadow-md active:scale-[0.98] transition-all duration-200"
                            >
                                <span x-text="selected"></span>
                                <svg class="w-4 h-4 text-slate-400 transition duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div
                                x-show="open"
                                @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute top-full mt-2 w-full bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden z-50"
                                x-cloak
                            >
                                <button type="button"
                                    @click="selected='Semua Produk'; $refs.filterInput.value=''; open=false; $nextTick(() => $el.closest('form').submit());"
                                    class="w-full px-4 py-2.5 text-left text-sm hover:bg-slate-50 transition">
                                    Semua Produk
                                </button>

                                <button type="button"
                                    @click="selected='Stok Habis'; $refs.filterInput.value='habis'; open=false; $nextTick(() => $el.closest('form').submit());"
                                    class="w-full px-4 py-2.5 text-left text-sm hover:bg-red-50 hover:text-red-600 transition">
                                    Stok Habis
                                </button>

                                <button type="button"
                                    @click="selected='Stok Menipis'; $refs.filterInput.value='menipis'; open=false; $nextTick(() => $el.closest('form').submit());"
                                    class="w-full px-4 py-2.5 text-left text-sm hover:bg-amber-50 hover:text-amber-600 transition">
                                    Stok Menipis
                                </button>
                            </div>
                        </div>

                        {{-- Tombol Reset (Hanya muncul kalau ada pencarian atau filter aktif) --}}
                        @if(request('search') || request('filter'))
                            <a
                                href="{{ route('admin.product.index') }}"
                                class="h-10 px-4 flex items-center justify-center bg-red-50 hover:bg-red-100 rounded-xl text-sm font-bold text-red-600 border border-red-100 transition-all duration-200"
                            >
                                Reset Filter
                            </a>
                        @endif

                    </form>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Produk ATK</h2>
                        <p class="text-sm text-slate-500 mt-1">Kelola seluruh produk alat tulis kantor toko kamu.</p>
                    </div>
                    <a href="{{ route('admin.product.create') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition-all duration-200 hover:shadow-lg self-start sm:self-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Produk
                    </a>
                </div>

                {{-- Toast Notifications --}}
                <div class="fixed bottom-5 left-1/2 -translate-x-1/2 md:top-5 md:right-5 md:bottom-auto md:left-auto md:translate-x-0 z-50 flex flex-col gap-2 w-full max-w-sm px-4 md:px-0">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="flex items-center gap-3 bg-white border border-emerald-100 text-emerald-700 px-4 py-3.5 rounded-2xl shadow-lg text-sm">
                            <div class="w-7 h-7 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <span class="font-medium flex-1">{{ session('success') }}</span>
                            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                             class="flex items-center gap-3 bg-white border border-red-100 text-red-700 px-4 py-3.5 rounded-2xl shadow-lg text-sm">
                            <div class="w-7 h-7 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-red-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <span class="font-medium flex-1">{{ session('error') }}</span>
                            <button @click="show = false" class="text-red-400 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Product Table --}}
                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-slate-700">Belum ada produk</p>
                        <p class="text-sm text-slate-400 mt-1 mb-6">Tambahkan produk ATK pertama kamu</p>
                        <a href="{{ route('admin.product.create') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Produk
                        </a>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        <th class="px-6 py-4">Produk</th>
                                        <th class="px-6 py-4">Kategori</th>
                                        <th class="px-6 py-4">Harga</th>
                                        <th class="px-6 py-4">Stok</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($products as $product)
                                    <tr class="hover:bg-slate-50/50 transition group {{ $product->stokMenipis() ? 'border-l-4 border-l-orange-400' : '' }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3.5">
                                                @if($product->foto)
                                                    <img src="{{ asset('storage/' . $product->foto) }}" class="w-11 h-11 rounded-xl object-cover border border-slate-100 shadow-sm">
                                                @else
                                                    <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-blue-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-slate-800 group-hover:text-blue-700 transition">{{ $product->nama }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5">{{ Str::limit($product->deskripsi, 45) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                                                {{ $product->category->nama }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-slate-900">
                                            {{ $product->hargaFormatted() }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($product->stok === 0)
                                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-2.5 py-1 rounded-lg text-xs font-bold border border-red-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Habis
                                                </span>
                                            @elseif($product->stokMenipis())
                                                <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 px-2.5 py-1 rounded-lg text-xs font-bold border border-orange-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                                    {{ $product->stok }} (menipis)
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-lg text-xs font-bold border border-emerald-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    {{ $product->stok }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($product->is_aktif)
                                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-lg text-xs font-bold border border-emerald-100">Aktif</span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 px-2.5 py-1 rounded-lg text-xs font-bold border border-slate-200">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.product.edit', $product) }}"
                                                   class="inline-flex items-center gap-1.5 text-xs bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg font-semibold border border-amber-100 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                {{-- Container Utama Modal Hapus Alpine.js --}}
                                                <div x-data="{ openDeleteModal: false }">

                                                    {{-- 1. Tombol Pemicu Utama (Di dalam tabel) --}}
                                                    <button type="button"
                                                            @click="openDeleteModal = true"
                                                            class="inline-flex items-center gap-1.5 text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg font-semibold border border-red-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                        Hapus
                                                    </button>

                                                    {{-- 2. Pop-up Modal Konfirmasi Hapus (Dilemparkan ke Body agar tidak kepotong tabel) --}}
                                                    <template x-teleport="body">
                                                        <div x-show="openDeleteModal"
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0"
                                                            x-transition:enter-end="opacity-100"
                                                            x-transition:leave="transition ease-in duration-150"
                                                            x-transition:leave-start="opacity-100"
                                                            x-transition:leave-end="opacity-0"
                                                            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                                            style="display: none;">

                                                            {{-- Kotak Putih Modal --}}
                                                            <div @click.away="openDeleteModal = false"
                                                                x-transition:enter="transition ease-out duration-300"
                                                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                                class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-2xl space-y-4">

                                                                {{-- Konten Informasi Peringatan --}}
                                                                <div class="flex items-center gap-3 text-left">
                                                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shrink-0">
                                                                        {{-- Ikon Peringatan (Warning) --}}
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text-left">
                                                                        <h3 class="text-base font-bold text-slate-900">Hapus Produk</h3>
                                                                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Yakin ingin menghapus <span class="font-bold text-slate-700">{{ $product->nama }}</span>? Data yang dihapus tidak dapat dikembalikan.</p>
                                                                    </div>
                                                                </div>

                                                                {{-- Tombol Pilihan Aksi --}}
                                                                <div class="grid grid-cols-2 gap-3 pt-2">
                                                                    {{-- Tombol Batal --}}
                                                                    <button type="button"
                                                                            @click="openDeleteModal = false"
                                                                            class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                                        Batal
                                                                    </button>

                                                                    {{-- Form Native DELETE Laravel --}}
                                                                    <form method="POST" action="{{ route('admin.product.destroy', $product) }}" class="m-0 p-0">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                                class="w-full h-10 text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition rounded-xl shadow-md shadow-red-500/10">
                                                                            Ya, Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </main>
        </div>
    </div>
</body>
</html>
