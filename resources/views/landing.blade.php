<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChoiATK - Toko Alat Tulis Kantor Terlengkap & Terpercaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
        }
        /* Custom animations & premium styling */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .radial-graph {
            background: radial-gradient(circle, rgba(239,246,255,1) 0%, rgba(219,234,254,0.5) 100%);
        }
    </style>
</head>
<body class="min-h-screen bg-[#F8FAFC] text-slate-800 antialiased selection:bg-blue-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <header class="sticky top-0 z-50 w-full border-b border-slate-100 bg-white/80 backdrop-blur-md transition-all duration-300">
        <div class="mx-auto flex max-w-7xl items-center justify-between p-4 md:px-8">
            <a href="#" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-10 sm:h-14 w-auto group-hover:scale-105 transition-transform duration-300">
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="#" class="text-sm font-semibold text-blue-600 transition-colors">Home</a>
                <a href="#katalog" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Katalog</a>
                <a href="#layanan" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Tentang Kami</a>
                <a href="#testimoni" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Testimoni</a>
            </nav>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('pelanggan.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2 text-sm font-semibold transition shadow-sm border border-red-100">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 text-sm font-bold shadow-md shadow-blue-500/20 hover:shadow-lg transition duration-300">
                        Daftar
                    </a>
                @endauth
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50 md:hidden transition">
                <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-collapse class="border-t border-slate-100 bg-white md:hidden" style="display: none;">
            <div class="space-y-1 p-4">
                <a href="#" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-2 text-base font-semibold text-blue-600 bg-blue-50/50">Home</a>
                <a href="#katalog" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Katalog</a>
                <a href="#layanan" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Tentang Kami</a>
                <a href="#testimoni" @click="mobileMenuOpen = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Testimoni</a>

                <div class="border-t border-slate-100 my-2 pt-2">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                        @else
                            <a href="{{ route('pelanggan.dashboard') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="pt-1">
                            @csrf
                            <button type="submit" class="w-full text-left block rounded-lg px-3 py-2 text-base font-semibold text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50">Login</a>
                        <a href="{{ route('register') }}" class="block mt-2 rounded-full bg-blue-600 text-center text-white px-3 py-2 text-base font-bold shadow-md shadow-blue-500/20 hover:bg-blue-700">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <section class="relative overflow-hidden pt-12 pb-24 md:pt-16 md:pb-32 bg-gradient-to-b from-blue-50/50 via-white to-[#F8FAFC]">
        <div class="mx-auto max-w-7xl px-4 md:px-8 relative z-10 text-center">

            <div data-aos="fade-up">
                <div class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-100 px-4 py-1.5 mb-6 hover:scale-102 transition duration-300">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-700 tracking-wide uppercase">Cari Kebutuhan ATK Sekarang ➡️</span>
                </div>

                <h1 class="mx-auto max-w-4xl text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl md:text-6xl leading-[1.15] mb-8">
                    <span class="text-blue-600">ATK</span> Terlengkap<br>
                    Untuk Anda.
                </h1>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto text-left">

                <div data-aos="fade-up" data-aos-delay="100" class="glass-card rounded-[2.5rem] p-8 shadow-xl shadow-blue-100/30 flex flex-col justify-between hover:translate-y-[-4px] transition duration-300">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-4">Best Sale</span>

                        <div class="space-y-6">
                            <div class="group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-800 group-hover:text-blue-600 transition">Kertas HVS A4</span>
                                    <span class="text-sm font-medium text-slate-400">Rp 46.000</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-400 h-full rounded-full w-[85%]"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                                    <span>Tersedia</span>
                                    <span>Paling Dicari</span>
                                </div>
                            </div>

                            <div class="group">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-800 group-hover:text-blue-600 transition">Pulpen Gel Zebra</span>
                                    <span class="text-sm font-medium text-slate-400">Rp 5.000</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-400 h-full rounded-full w-[95%]"></div>
                                </div>
                                <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                                    <span>Tersedia</span>
                                    <span>Hot Item</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="200" class="glass-card rounded-[2.5rem] p-8 shadow-xl shadow-blue-200/40 relative border-blue-100 hover:translate-y-[-4px] transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="inline-block rounded-full bg-blue-50 border border-blue-100 px-3.5 py-1 mb-6">
                            <span class="text-[10px] font-extrabold text-blue-600 uppercase tracking-widest">Dapatkan Diskon Menarik Hingga 30%</span>
                        </div>
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-snug">
                            Solusi Terpadu untuk Kebutuhan ATK Anda.
                        </h3>
                    </div>

                    <div class="mt-8">
                        <a href="{{route('login')}}" class="w-full inline-flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white py-3 text-sm font-bold shadow-md shadow-blue-500/20 transition-all duration-300">
                            Daftar & Beli
                        </a>

                        <div class="mt-6 flex items-center justify-between bg-slate-50 border border-slate-100 rounded-2xl p-4">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Promo Hari Ini</span>
                                <span class="font-bold text-slate-800 text-sm">Paket Hemat Belajar</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs line-through text-slate-400 block">Rp 25.000</span>
                                <span class="text-sm font-extrabold text-blue-600">Rp 17.500</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="300" class="glass-card rounded-[2.5rem] p-8 shadow-xl shadow-blue-100/30 flex flex-col justify-between hover:translate-y-[-4px] transition duration-300">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-4">Penawaran Terbaik</span>

                        <div class="flex justify-center items-center my-4 relative">
                            <svg class="w-32 h-32 transform -rotate-90">
                                <circle cx="64" cy="64" r="50" stroke="#f1f5f9" stroke-width="12" fill="transparent" />
                                <circle cx="64" cy="64" r="50" stroke="#3b82f6" stroke-width="12" fill="transparent"
                                        stroke-dasharray="314.16" stroke-dashoffset="94.25" stroke-linecap="round" />
                            </svg>
                            <div class="absolute flex flex-col items-center justify-center">
                                <span class="text-2xl font-extrabold text-slate-900">70%</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Terjual</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 text-center leading-relaxed mt-4">
                            Miliki alat tulis berkualitas dengan harga paling bersaing untuk kantor dan sekolah.
                        </p>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <a href="#katalog" class="inline-flex items-center gap-1 text-sm font-extrabold text-blue-600 hover:text-blue-700 group transition">
                            See More
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="absolute top-[20%] left-[-10%] w-96 h-96 bg-blue-400/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-96 h-96 bg-emerald-400/10 rounded-full blur-[120px] pointer-events-none"></div>
    </section>

    <section id="katalog" class="mx-auto max-w-7xl px-4 md:px-8 py-16"
             x-data="{
                products: {{ json_encode($products) }},
                categories: {{ json_encode($categories) }},
                activeCategory: 'Semua',
                search: '',
                currentPage: 1,
                itemsPerPage: 5,
                get filteredProducts() {
                    return this.products.filter(p => {
                        const matchesSearch = p.nama.toLowerCase().includes(this.search.toLowerCase());
                        const matchesCategory = this.activeCategory === 'Semua' || p.category.nama === this.activeCategory;
                        return matchesSearch && matchesCategory;
                    });
                },
                get paginatedProducts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredProducts.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredProducts.length / this.itemsPerPage) || 1;
                },
                formatHarga(harga) {
                    return 'Rp ' + Number(harga).toLocaleString('id-ID');
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                }
             }" x-init="$watch('activeCategory', value => currentPage = 1); $watch('search', value => currentPage = 1)">

        <div class="text-center max-w-3xl mx-auto mb-12" data-aos="fade-up">
            <div class="inline-block rounded-full bg-slate-100 border border-slate-200 px-4 py-1 mb-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Daftar Harga</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">
                Daftar Harga Langsung
            </h2>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                Lebih murah dari harga pasar, stok dan harga di bawah ini selalu diperbarui secara real-time.
            </p>
        </div>

        <div data-aos="fade-up" data-aos-delay="100">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6 mb-8 bg-white border border-slate-100 shadow-sm p-4 rounded-3xl">
                <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
                    <button @click="activeCategory = 'Semua'"
                            :class="activeCategory === 'Semua' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-100'"
                            class="rounded-full px-5 py-2 text-xs font-bold transition duration-300">
                        Semua
                    </button>
                    <template x-for="cat in categories" :key="cat.id">
                        <button @click="activeCategory = cat.nama"
                                :class="activeCategory === cat.nama ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border border-slate-100'"
                                class="rounded-full px-5 py-2 text-xs font-bold transition duration-300"
                                x-text="cat.nama">
                        </button>
                    </template>
                </div>

                <div class="relative w-full lg:w-80">
                    <input x-model="search" type="text" placeholder="Cari Produk..."
                           class="w-full bg-slate-50 hover:bg-slate-100/50 focus:bg-white border border-slate-200 focus:border-blue-500 rounded-full px-6 py-2.5 pl-12 text-xs font-medium outline-none transition duration-300">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.602 10.602z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-slate-100 rounded-3xl shadow-md shadow-slate-100/50">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
                                <th class="p-5">KATEGORI</th>
                                <th class="p-5">PRODUK</th>
                                <th class="p-5">HARGA</th>
                                <th class="p-5">STATUS</th>
                                <th class="p-5 text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">

                            <template x-for="p in paginatedProducts" :key="p.id">
                                <tr class="hover:bg-slate-50/50 transition duration-150">
                                    <td class="p-5 font-semibold text-slate-500" x-text="p.category.nama"></td>
                                    <td class="p-5 font-bold text-slate-800">
                                        <div class="flex flex-col gap-1">
                                            <span x-text="p.nama"></span>
                                            <span class="text-[10px] font-normal text-slate-400" x-text="p.deskripsi || 'Tidak ada deskripsi'"></span>
                                        </div>
                                    </td>
                                    <td class="p-5 font-extrabold text-blue-600 text-sm" x-text="formatHarga(p.harga)"></td>
                                    <td class="p-5">
                                        <template x-if="p.stok === 0">
                                            <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-[10px] font-bold text-red-600 border border-red-100">Habis</span>
                                        </template>
                                        <template x-if="p.stok > 0 && p.stok <= p.stok_minimum">
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold text-amber-600 border border-amber-100">Menipis</span>
                                        </template>
                                        <template x-if="p.stok > p.stok_minimum">
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600 border border-emerald-100">Tersedia</span>
                                        </template>
                                    </td>
                                    <td class="p-5 text-center">
                                        @auth
                                            <template x-if="p.stok > 0">
                                                <a :href="'{{ route('login') }}?search=' + encodeURIComponent(p.nama)"
                                                   class="inline-flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 text-xs font-bold shadow-sm shadow-blue-500/10 transition-all duration-300">
                                                    Beli Sekarang
                                                </a>
                                            </template>
                                            <template x-if="p.stok === 0">
                                                <button disabled class="inline-flex items-center justify-center rounded-full bg-slate-100 text-slate-400 px-5 py-2 text-xs font-bold border border-slate-200 cursor-not-allowed">
                                                    Habis
                                                </button>
                                            </template>
                                        @else
                                            <template x-if="p.stok > 0">
                                                <a href="{{ route('login') }}"
                                                   class="inline-flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 text-xs font-bold shadow-sm shadow-blue-500/10 transition-all duration-300">
                                                    Beli Sekarang
                                                </a>
                                            </template>
                                            <template x-if="p.stok === 0">
                                                <button disabled class="inline-flex items-center justify-center rounded-full bg-slate-100 text-slate-400 px-5 py-2 text-xs font-bold border border-slate-200 cursor-not-allowed">
                                                    Habis
                                                </button>
                                            </template>
                                        @endauth
                                    </td>
                                </tr>
                            </template>

                            <template x-if="filteredProducts.length === 0">
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-slate-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0121.75 21H2.25A2.25 2.25 0 010 18.75v-4.5A2.25 2.25 0 012.25 13.5z" />
                                        </svg>
                                        <span class="text-sm font-semibold">Produk tidak ditemukan</span>
                                        <p class="text-[11px] mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>

                <div x-show="filteredProducts.length > 0" class="flex items-center justify-between p-4 bg-slate-50/50 border-t border-slate-100 text-xs">
                    <span class="text-slate-400 font-medium" x-text="'Menampilkan ' + paginatedProducts.length + ' dari ' + filteredProducts.length + ' produk'"></span>
                    <div class="flex items-center gap-1.5">
                        <button @click="prevPage" :disabled="currentPage === 1"
                                :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed bg-white border border-slate-100 text-slate-400' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 active:scale-95'"
                                class="h-8 w-8 rounded-lg flex items-center justify-center font-bold shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <div class="h-8 px-3 rounded-lg border border-blue-100 bg-blue-50 text-blue-600 font-extrabold flex items-center justify-center shadow-sm" x-text="currentPage"></div>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                                :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed bg-white border border-slate-100 text-slate-400' : 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 active:scale-95'"
                                class="h-8 w-8 rounded-lg flex items-center justify-center font-bold shadow-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="layanan" class="mx-auto max-w-7xl px-4 md:px-8 py-16">
        <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-emerald-500 rounded-[3rem] p-8 md:p-16 text-white shadow-2xl relative overflow-hidden">

            <div class="relative z-10 text-center max-w-3xl mx-auto" data-aos="fade-up">
                <div class="inline-block rounded-full bg-white/10 border border-white/20 px-4.5 py-1 mb-4">
                    <span class="text-xs font-bold text-white uppercase tracking-widest">Services</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-snug">
                    Layanan <span class="text-emerald-300">Populer</span> Kami
                </h2>
                <p class="mt-4 text-sm text-blue-100 max-w-2xl mx-auto leading-relaxed">
                    Semua yang Anda butuhkan untuk menjaga kelancaran sekaligus produktivitas kantor dan sekolah Anda, selalu siap membantu Anda.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 relative z-10">
                <div data-aos="fade-up" data-aos-delay="100" class="bg-white text-slate-800 rounded-3xl p-8 shadow-lg hover:scale-102 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mb-6">1</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Alat Tulis</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pena berkualitas, pensil 2B untuk ujian, spidol whiteboard, penghapus bersih, penggaris presisi, dan perlengkapan lainnya.
                        </p>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">10+ Brand</span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-0.5">Order Now</a>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="200" class="bg-white text-slate-800 rounded-3xl p-8 shadow-lg hover:scale-102 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mb-6">2</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Kertas & Buku</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Kertas HVS tebal (A4/F4), buku tulis sekolah beraneka halaman, notebook spiral elegan, map arsip plastik, dan binder ring.
                        </p>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Premium Quality</span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-0.5">Order Now</a>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="300" class="bg-white text-slate-800 rounded-3xl p-8 shadow-lg hover:scale-102 transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mb-6">3</div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Peralatan Kantor</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Stapler kokoh, staples refill, gunting kertas stainless steel, lem kertas rekat kuat, cutter tajam, dan kalkulator akuntansi.
                        </p>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Lengkap & Murah</span>
                        <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-0.5">Order Now</a>
                    </div>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="400" class="mt-6 bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">4</div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Grosir & Pesan Antar</h3>
                        <p class="text-xs text-blue-100 leading-relaxed">
                            Makin mudah, praktis, dan hemat dengan layanan pembelian grosir untuk stok kantor atau sekolah. Kami kirim langsung ke lokasi Anda!
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0 bg-white/10 px-4 py-2 rounded-2xl border border-white/10">
                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">Mitra Kami:</span>
                    <span class="text-xs font-extrabold text-blue-200">Joyko</span>
                    <span class="text-xs font-extrabold text-emerald-200">Snowman</span>
                    <span class="text-xs font-extrabold text-amber-200">PaperOne</span>
                </div>
            </div>

            <div class="absolute -right-16 -top-16 w-64 h-64 bg-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-white/5 rounded-full pointer-events-none"></div>
        </div>
    </section>

    <section id="testimoni" class="mx-auto max-w-7xl px-4 md:px-8 py-16 bg-gradient-to-b from-[#F8FAFC] via-white to-blue-50/20">

        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <div class="inline-block rounded-full bg-emerald-50 border border-emerald-100 px-4 py-1 mb-4">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Testimonials</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                <span class="text-emerald-500">Dipercaya</span> Oleh Ribuan Orang
            </h2>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                Layanan kami didukung oleh kualitas produk premium dan responsivitas customer service yang handal.
            </p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto items-start">

            <!-- Card 1 (rotate-1) -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xl shadow-slate-100/40 rotate-[-1.5deg] hover:rotate-0 hover:scale-102 hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
                <div class="text-blue-500 mb-4">
                    <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.635-3.996 5.848h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800 leading-relaxed mb-6">
                    "Paling Murah Dibanding Platform Lain, Bagus Pisan Asli"
                </p>
                <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Budi Santoso</h4>
                        <span class="text-[10px] text-slate-400">Pembeli Grosir Kantor</span>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card 2 (rotate-1) -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xl shadow-slate-100/40 rotate-[1deg] hover:rotate-0 hover:scale-102 hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
                <div class="text-blue-500 mb-4">
                    <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.635-3.996 5.848h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800 leading-relaxed mb-6">
                    "Gampangg Banget Pesennya, Kalian Yang Belum Coba Harus Coba Sih?"
                </p>
                <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Linda Wijaya</h4>
                        <span class="text-[10px] text-slate-400">Mahasiswi</span>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card 3 (rotate-2) -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xl shadow-slate-100/40 rotate-[-1deg] hover:rotate-0 hover:scale-102 hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
                <div class="text-blue-500 mb-4">
                    <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.635-3.996 5.848h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800 leading-relaxed mb-6">
                    "Customer Servicenya Responsif Banget! Recommended seller pokoknya."
                </p>
                <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Rian Pratama</h4>
                        <span class="text-[10px] text-slate-400">Admin Sekolah</span>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card 4 (middle row center offset) -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xl shadow-slate-100/40 rotate-[1.5deg] hover:rotate-0 hover:scale-102 hover:shadow-2xl hover:border-blue-100 transition-all duration-300 sm:col-start-1 lg:col-start-2 lg:col-span-1">
                <div class="text-blue-500 mb-4">
                    <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.635-3.996 5.848h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800 leading-relaxed mb-6">
                    "Desainnya Keren Banget Asli Ril No Fek Fek"
                </p>
                <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Alif Ramadhan</h4>
                        <span class="text-[10px] text-slate-400">Freelancer</span>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xl shadow-slate-100/40 rotate-[-1.5deg] hover:rotate-0 hover:scale-102 hover:shadow-2xl hover:border-blue-100 transition-all duration-300 lg:col-start-3">
                <div class="text-blue-500 mb-4">
                    <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.635-3.996 5.848h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-800 leading-relaxed mb-6">
                    "Baru Nyobain Request Langsung Auto Masuk Pulpennya!"
                </p>
                <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900">Citra Kirana</h4>
                        <span class="text-[10px] text-slate-400">Guru</span>
                    </div>
                    <div class="flex items-center gap-0.5 text-amber-400">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </template>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <footer class="bg-blue-600 text-white border-t border-blue-500 pt-16 pb-8">
        <div class="mx-auto max-w-7xl px-4 md:px-8">
            <div class="grid gap-8 grid-cols-2 md:grid-cols-4 mb-12">

                <div class="md:col-span-1">
                    <a href="#" class="inline-block group mb-6">
                        <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-100 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-10 sm:h-14 w-auto object-contain">
                        </div>
                    </a>
                    <p class="text-xs text-blue-100 leading-relaxed mb-4">
                        Solusi terlengkap, termurah, dan terpercaya untuk menjaga kelancaran sekaligus digitalitas alat tulis kantor & sekolah Anda.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-blue-100 mb-6">Pembayaran</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-white/10 border border-white/10 px-3 py-1 rounded text-[10px] font-bold text-white">CASH</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-blue-100 mb-6">Layanan</h3>
                    <ul class="space-y-3 text-xs text-blue-100">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#katalog" class="hover:text-white transition">Katalog</a></li>
                        <li><a href="#layanan" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#testimoni" class="hover:text-white transition">Testimoni</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-blue-100 mb-6">Ikuti Kami</h3>
                    <ul class="space-y-3 text-xs text-blue-100">
                        <li>
                            <a href="#" class="inline-flex items-center gap-2 hover:text-white transition">
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center gap-2 hover:text-white transition">
                                <span>Tiktok</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center gap-2 hover:text-white transition">
                                <span>WhatsApp Support</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-blue-500 pt-8 mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-blue-200">
                <span>Copyright © 2026 ChoiATK. All Rights Reserved.</span>
                <span class="font-medium">Made with ❤️ for ChoiATK Project</span>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800,      // Durasi animasi (800ms)
            easing: 'ease-out-cubic', // Efek easing biar pergerakannya halus banget
            once: true,         // Animasi cuma jalan sekali
            offset: 100,        // Mulai animasi saat elemen 100px masuk layar
        });
    </script>
</body>
</html>
