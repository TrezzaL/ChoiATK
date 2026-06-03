<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 animate-page-load">
                <div class="max-w-2xl mx-auto">

                    {{-- Header --}}
                    <div class="mb-6">
                        <a href="{{ route('admin.product.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali ke Daftar Produk
                        </a>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Produk</h2>
                        <p class="text-sm text-slate-500 mt-1">Ubah data produk <span class="font-semibold text-slate-700">{{ $product->nama }}</span>.</p>
                    </div>

                    {{-- Form Card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                        <form method="POST" action="{{ route('admin.product.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf @method('PUT')

                            {{-- Kategori (Alpine.js Custom Dropdown) --}}
                            @php
                                // Logika PHP untuk mencari nama kategori yang sedang terpilih (baik dari database saat edit, atau dari old() saat error validasi)
                                $oldCategoryId = old('category_id', $product->category_id ?? '');
                                $oldCategoryName = 'Pilih Kategori';

                                if ($oldCategoryId) {
                                    $selectedCat = $categories->firstWhere('id', $oldCategoryId);
                                    if ($selectedCat) {
                                        $oldCategoryName = $selectedCat->nama;
                                    }
                                }
                            @endphp

                            <div class="relative"
                                x-data="{
                                    open: false,
                                    selectedId: '{{ $oldCategoryId }}',
                                    selectedName: '{{ $oldCategoryName }}',
                                    selectOption(id, name) {
                                        this.selectedId = id;
                                        this.selectedName = name;
                                        this.open = false;
                                    }
                                }">

                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kategori</label>

                                {{-- Hidden Input: Ini yang akan dikirim ke Laravel Backend --}}
                                <input type="hidden" name="category_id" :value="selectedId" required>

                                {{-- Tombol Utama Dropdown --}}
                                <button type="button"
                                        @click="open = !open"
                                        @click.away="open = false"
                                        class="w-full px-4 py-3 rounded-xl border flex items-center justify-between transition-all duration-200 focus:outline-none"
                                        :class="open ? 'border-blue-500 ring-4 ring-blue-50 bg-white' : 'border-slate-200 bg-white hover:border-blue-300'">

                                    <span class="text-sm font-medium"
                                        :class="selectedId ? 'text-slate-700' : 'text-slate-400'"
                                        x-text="selectedName">
                                    </span>

                                    {{-- Ikon Panah Berputar --}}
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                        :class="open ? 'rotate-180 text-blue-500' : ''"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- List Menu Dropdown --}}
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                    class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl py-1.5 max-h-60 overflow-y-auto"
                                    style="display: none;">

                                    @foreach($categories as $category)
                                        <button type="button"
                                                @click="selectOption('{{ $category->id }}', '{{ $category->nama }}')"
                                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between"
                                                :class="selectedId == '{{ $category->id }}' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'">

                                            <span>{{ $category->nama }}</span>

                                            {{-- Ikon Ceklis muncul jika kategori ini sedang dipilih --}}
                                            <svg x-show="selectedId == '{{ $category->id }}'"
                                                xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Nama Produk --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Produk</label>
                                <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Deskripsi <span class="text-slate-300 font-normal lowercase normal-case">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition resize-none">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            </div>

                            {{-- Harga & Stok --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Harga (Rp)</label>
                                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Stok</label>
                                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                                </div>
                            </div>

                            {{-- Stok Minimum --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Batas Stok Minimum</label>
                                <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $product->stok_minimum) }}" required min="1"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Foto Produk</label>
                                @if($product->foto)
                                    <div class="flex items-center gap-4 mb-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <img src="{{ asset('storage/' . $product->foto) }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200">
                                        <p class="text-xs text-slate-500">Upload foto baru untuk mengganti foto saat ini.</p>
                                    </div>
                                @endif
                                <input type="file" name="foto" accept="image/*"
                                    class="w-full text-sm text-slate-500
                                        file:mr-4 file:py-2.5 file:px-4
                                        file:rounded-xl file:border-0
                                        file:bg-blue-50 file:text-blue-700 file:font-semibold
                                        hover:file:bg-blue-100 file:transition">
                            </div>

                            {{-- Toggle Aktif --}}
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input type="checkbox" name="is_aktif" id="is_aktif"
                                        {{ old('is_aktif', $product->is_aktif) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-10 h-6 bg-slate-200 peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                                <label for="is_aktif" class="text-sm font-semibold text-slate-700 cursor-pointer">
                                    Produk Aktif
                                </label>
                                <span class="text-xs text-slate-400">(tampil di katalog pelanggan)</span>
                            </div>

                            {{-- Actions --}}
                            <div class="border-t border-slate-100 pt-5 flex gap-3">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md shadow-blue-500/20 text-sm">
                                    Update Produk
                                </button>
                                <a href="{{ route('admin.product.index') }}"
                                    class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl transition text-sm">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>
