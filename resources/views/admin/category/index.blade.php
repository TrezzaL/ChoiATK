<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Produk — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased"
      x-data="{
          modalOpen: false,
          activeCategory: { nama: '', products: [] },
          showDetail(categoryName, productsList) {
              this.activeCategory = { nama: categoryName, products: productsList };
              this.modalOpen = true;
          }
      }">

    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Page Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Kategori Produk</h2>
                        <p class="text-sm text-slate-500 mt-1">Kelola kelompok/kategori produk ATK toko kamu.</p>
                    </div>
                    <a href="{{ route('admin.category.create') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition-all duration-200 self-start sm:self-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Kategori
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
                            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
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
                            <button @click="show = false" class="text-red-400 hover:text-red-600">✕</button>
                        </div>
                    @endif
                </div>

                {{-- Category Table --}}
                @if($categories->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-slate-700">Belum ada kategori</p>
                        <p class="text-sm text-slate-400 mt-1 mb-6">Tambahkan kategori produk ATK pertama kamu</p>
                        <a href="{{ route('admin.category.create') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        <th class="px-6 py-4">Nama Kategori</th>
                                        <th class="px-6 py-4">Deskripsi</th>
                                        <th class="px-6 py-4">Jumlah Produk</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($categories as $category)
                                    <tr class="hover:bg-slate-50/50 transition group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                </div>
                                                <span class="font-semibold text-slate-800 group-hover:text-blue-700 transition">{{ $category->nama }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                            {{ $category->deskripsi ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold border border-blue-100">
                                                {{ $category->products_count }} produk
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                {{-- Tombol Detail --}}
                                                <button type="button"
                                                        @click="showDetail('{{ $category->nama }}', {{ $category->products->toJson() }})"
                                                        class="inline-flex items-center gap-1.5 text-xs bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-lg font-semibold border border-blue-100 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Detail
                                                </button>

                                                <a href="{{ route('admin.category.edit', $category) }}"
                                                   class="inline-flex items-center gap-1.5 text-xs bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-1.5 rounded-lg font-semibold border border-amber-100 transition">
                                                    <svg xmlns="http://www.w3.org/2000/xl" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                {{-- Container Utama Modal Hapus Kategori Alpine.js --}}
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

                                                                {{-- Konten Informasi Peringatan Bahaya --}}
                                                                <div class="flex items-start gap-3 text-left">
                                                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shrink-0 mt-0.5">
                                                                        {{-- Ikon Peringatan (Warning) --}}
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="text-left">
                                                                        <h3 class="text-base font-bold text-slate-900">Hapus Kategori</h3>
                                                                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                                                                            Yakin ingin menghapus kategori <span class="font-bold text-slate-800">{{ $category->nama }}</span>?<br>
                                                                            <span class="inline-block mt-1.5 text-red-600 font-semibold bg-red-50 py-1 px-2 rounded border border-red-100">
                                                                                ⚠️ Semua produk di dalamnya juga akan ikut terhapus!
                                                                            </span>
                                                                        </p>
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
                                                                    <form method="POST" action="{{ route('admin.category.destroy', $category) }}" class="m-0 p-0">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                                class="w-full h-10 text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition rounded-xl shadow-md shadow-red-500/10">
                                                                            Ya, Hapus Semua
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

    {{-- MODAL DETAIL PRODUK KATEGORI (Alpine.js) --}}
    <div x-show="modalOpen"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         @keydown.escape.window="modalOpen = false">

        {{-- Backdrop / Overlay dengan Efek Blur & Fade --}}
        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"
             @click="modalOpen = false">
        </div>

        {{-- Konten Utama Modal dengan Animasi Pop-Up Halus --}}
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl border border-slate-100 transition-all">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Daftar Produk Kategori</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Kategori: <span class="text-blue-600 font-semibold" x-text="activeCategory.nama"></span></p>
                    </div>
                    <button @click="modalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 hover:bg-slate-50 rounded-xl transition">✕</button>
                </div>

                {{-- Modal Body (Daftar Produk) --}}
                <div class="max-h-96 overflow-y-auto space-y-2.5 pr-1">
                    {{-- Keadaan ketika kategori tidak memiliki produk --}}
                    <template x-if="activeCategory.products.length === 0">
                        <div class="text-center py-8 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2 text-slate-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            <p class="text-sm">Belum ada produk yang terdaftar di kategori ini.</p>
                        </div>
                    </template>

                    {{-- Perulangan List Produk menggunakan template x-for --}}
                    <template x-for="(product, index) in activeCategory.products" :key="product.id">
                        <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-white border border-slate-100 text-slate-500 rounded-lg flex items-center justify-center text-xs font-bold" x-text="index + 1"></div>
                                <div>
                                    <h4 class="font-semibold text-slate-800 text-sm" x-text="product.nama"></h4>
                                    <p class="text-xs text-slate-400 mt-0.5">Stok: <span x-text="product.stok"></span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-slate-900" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(product.harga)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Modal Footer --}}
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                    <button type="button"
                            @click="modalOpen = false"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl text-sm transition">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
