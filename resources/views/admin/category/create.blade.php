<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 animate-page-load">
                <div class="max-w-xl mx-auto">

                    {{-- Header --}}
                    <div class="mb-6">
                        <a href="{{ route('admin.category.index') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Kembali ke Daftar Kategori
                        </a>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Kategori Baru</h2>
                        <p class="text-sm text-slate-500 mt-1">Buat kategori untuk mengelompokkan produk ATK di toko kamu.</p>
                    </div>

                    {{-- Form Card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 sm:p-8">
                        <form method="POST" action="{{ route('admin.category.store') }}" class="space-y-5">
                            @csrf

                            {{-- Nama --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Kategori</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('nama') border-red-400 ring-2 ring-red-200 @enderror"
                                    placeholder="Contoh: Alat Tulis, Kertas & Buku, Peralatan Kantor">
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Deskripsi <span class="text-slate-300 font-normal lowercase normal-case">(opsional)</span>
                                </label>
                                <textarea name="deskripsi" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition resize-none"
                                    placeholder="Tulis deskripsi singkat mengenai kategori ini...">{{ old('deskripsi') }}</textarea>
                            </div>

                            {{-- Actions --}}
                            <div class="border-t border-slate-100 pt-5 flex gap-3">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md shadow-blue-500/20 text-sm">
                                    Simpan Kategori
                                </button>
                                <a href="{{ route('admin.category.index') }}"
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
