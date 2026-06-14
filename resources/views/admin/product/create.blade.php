<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
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
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Produk Baru</h2>
                        <p class="text-sm text-slate-500 mt-1">Daftarkan item ATK baru ke dalam toko kamu.</p>
                    </div>

                    {{-- Form Card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
                        <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            {{-- Kategori (Kustom dengan Alpine.js) --}}
                            <div x-data="{
                                open: false,
                                selectedId: '{{ old('category_id') }}',
                                selectedNama: '{{ old('category_id') ? $categories->firstWhere('id', old('category_id'))->nama : '— Pilih Kategori —' }}'
                            }"
                            class="relative"
                            @click.outside="open = false">

                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kategori</label>

                                {{-- Elemen Select Asli (Disembunyikan, untuk kirim data form ke Laravel) --}}
                                <select name="category_id" required class="hidden">
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" :selected="selectedId == {{ $category->id }}"></option>
                                    @endforeach
                                </select>

                                {{-- Tombol Dropdown yang Terlihat oleh User --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl border bg-white text-sm text-slate-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500
                                    @error('category_id') border-red-400 ring-2 ring-red-200 @else border-slate-200 @enderror">
                                    <span x-text="selectedNama" :class="selectedId ? 'text-slate-800 font-medium' : 'text-slate-400'"></span>

                                    {{-- Icon Panah Reaktif (Berputar saat dropdown terbuka) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                        class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180 text-blue-500' : ''">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>

                                {{-- Menu List Pilihan (Muncul dengan Animasi Memudar & Bergeser Halus) --}}
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 transform scale-95 -translate-y-2"
                                    class="absolute z-30 mt-2 w-full bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto p-1.5 space-y-0.5 focus:outline-none"
                                    style="display: none;">

                                    {{-- Opsi Default / Kosong --}}
                                    <button type="button" @click="selectedId = ''; selectedNama = '— Pilih Kategori —'; open = false"
                                        class="w-full text-left px-3 py-2.5 rounded-lg text-xs font-semibold uppercase tracking-wider text-slate-400 hover:bg-slate-50 transition">
                                        — Batalkan Pilihan —
                                    </button>

                                    {{-- Looping Kategori dari Database --}}
                                    @foreach($categories as $category)
                                        <button type="button"
                                            @click="selectedId = '{{ $category->id }}'; selectedNama = '{{ $category->nama }}'; open = false"
                                            class="w-full text-left px-4 py-2.5 rounded-lg text-sm transition flex items-center justify-between"
                                            :class="selectedId == '{{ $category->id }}' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50'">

                                            <span x-text="'{{ $category->nama }}'"></span>

                                            {{-- Icon Checkmark jika opsi ini sedang terpilih --}}
                                            <svg x-show="selectedId == '{{ $category->id }}'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </button>
                                    @endforeach
                                </div>

                                {{-- Tampilan Error Laravel Validation --}}
                                @error('category_id')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Nama Produk --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Produk</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('nama') border-red-400 ring-2 ring-red-200 @enderror"
                                    placeholder="Contoh: Pulpen Gel Zebra Piccolo">

                                {{-- INFORMASI FORMAT PENGISIAN BARU --}}
                                <div class="mt-1.5 flex items-start gap-1 text-[11px] text-slate-400 leading-normal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-blue-500 shrink-0 mt-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.083 1.083l-.02.041m-1.104-1.104l.02-.041m1.104 1.104l-.041.02M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span>Format standar: <strong class="text-slate-600">Nama Barang + Merk + Spesifikasi/Ukuran</strong> (Contoh: <span class="italic">Kertas HVS A4 80gr PaperOne</span> atau <span class="italic">Buku Tulis Sidu 38 Lembar</span>).</span>
                                </div>

                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Deskripsi <span class="text-slate-300 font-normal lowercase normal-case">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition resize-none"
                                    placeholder="Deskripsi singkat produk...">{{ old('deskripsi') }}</textarea>
                            </div>

                            {{-- Harga & Stok --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Harga (Rp)</label>
                                    <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('harga') border-red-400 ring-2 ring-red-200 @enderror"
                                        placeholder="5000">
                                    @error('harga')
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Stok Awal</label>
                                    <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('stok') border-red-400 ring-2 ring-red-200 @enderror"
                                        placeholder="10">
                                    @error('stok')
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Stok Minimum --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Batas Stok Minimum
                                </label>
                                <p class="text-xs text-slate-400 mb-2">Sistem akan memberikan peringatan jika stok di bawah angka ini.</p>
                                <input type="number" name="stok_minimum" value="{{ old('stok_minimum', 5) }}" required min="1"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition"
                                    placeholder="5">
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Foto Produk <span class="text-slate-300 font-normal lowercase normal-case">(opsional)</span>
                                </label>
                                <input type="file" name="foto" accept="image/*"
                                    class="w-full text-sm text-slate-500
                                        file:mr-4 file:py-2.5 file:px-4
                                        file:rounded-xl file:border-0
                                        file:bg-blue-50 file:text-blue-700 file:font-semibold
                                        hover:file:bg-blue-100 file:transition">
                                @error('foto')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Divider --}}
                            <div class="border-t border-slate-100 pt-5 flex gap-3">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md shadow-blue-500/20 text-sm">
                                    Simpan Produk
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
