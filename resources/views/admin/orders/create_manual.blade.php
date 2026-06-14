<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Order Offline — Panel Admin ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto min-h-screen">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div>
                    <a href="{{ route('admin.order.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Kembali ke Daftar Order
                    </a>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Input Transaksi Offline</h2>
                    <p class="text-sm text-slate-500 mt-1">Catat transaksi pembelian langsung di konter fisik toko.</p>
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                         class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-red-50 border border-red-100 text-red-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Form dengan Fitur Live Search Alpine --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start"
                     x-data="{
                         searchQuery: '',
                         searchOpen: false,
                         selectedProduct: null,
                         qty: {{ old('jumlah', 1) }},
                         delivery: '{{ old('tipe_penyerahan', 'ambil') }}',
                         payment: '{{ old('metode_bayar', 'cash') }}',
                         products: {{ json_encode($products->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama, 'harga' => $p->harga, 'stok' => $p->stok, 'kategori' => $p->category->nama ?? 'ATK'])) }},

                         get filteredProducts() {
                             if (this.searchQuery.trim() === '') return this.products;
                             return this.products.filter(p => p.nama.toLowerCase().includes(this.searchQuery.toLowerCase()));
                         },
                         get selectedProductData() {
                             return this.products.find(p => p.id == this.selectedProduct) ?? null;
                         },
                         get totalHarga() {
                             return this.selectedProductData ? this.selectedProductData.harga * this.qty : 0;
                         },
                         get maxStok() {
                             return this.selectedProductData ? this.selectedProductData.stok : 9999;
                         },
                         selectProduct(product) {
                             this.selectedProduct = product.id;
                             this.searchQuery = product.nama;
                             this.searchOpen = false;
                         },
                         formatRupiah(n) {
                             return 'Rp ' + n.toLocaleString('id-ID');
                         }
                     }"
                     x-init="
                        let oldId = '{{ old('product_id', '') }}';
                        if(oldId) {
                            selectedProduct = oldId;
                            let p = products.find(prod => prod.id == oldId);
                            if(p) searchQuery = p.nama;
                        }
                     ">

                    {{-- LEFT: Form Input --}}
                    <div class="lg:col-span-2 space-y-5">
                        <form action="{{ route('admin.order.store_manual') }}" method="POST" id="manualForm">
                            @csrf

                            {{-- Input Hidden untuk mengirim ID Produk ke Controller Laravel --}}
                            <input type="hidden" name="product_id" :value="selectedProduct">

                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">Detail Transaksi</h3>
                                </div>

                                <div class="p-6 space-y-5">

                                    {{-- FITUR BARU: Live Search Product Autocomplete --}}
                                    <div class="relative" @click.away="searchOpen = false">
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                            Cari & Pilih Produk ATK <span class="text-red-400">*</span>
                                        </label>

                                        <div class="relative">
                                            <input type="text"
                                                   x-model="searchQuery"
                                                   @focus="searchOpen = true; selectedProduct = null"
                                                   @input="searchOpen = true"
                                                   placeholder="Ketik nama alat tulis yang dicari... (Contoh: Pulpen, Buku)"
                                                   class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition {{ $errors->has('product_id') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}">

                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                            </div>
                                        </div>

                                        {{-- Dropdown Hasil Pencarian Live --}}
                                        <div x-show="searchOpen && filteredProducts.length > 0"
                                             x-transition
                                             class="absolute z-50 mt-1.5 w-full bg-white border border-slate-100 shadow-xl rounded-xl max-h-60 overflow-y-auto divide-y divide-slate-50"
                                             style="display: none;">
                                            <template x-for="product in filteredProducts" :key="product.id">
                                                <button type="button" @click="selectProduct(product)"
                                                        class="w-full text-left px-4 py-3 text-sm hover:bg-blue-50/60 transition flex items-center justify-between">
                                                    <div>
                                                        <span class="font-semibold text-slate-800" x-text="product.nama"></span>
                                                        <p class="text-[11px] text-slate-400 mt-0.5" x-text="product.kategori"></p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="text-xs font-bold text-blue-600 block" x-text="formatRupiah(product.harga)"></span>
                                                        <span class="text-[10px] text-slate-400" x-text="'Stok: ' + product.stok + ' pcs'"></span>
                                                    </div>
                                                </button>
                                            </template>
                                        </div>

                                        {{-- State jika produk tidak ditemukan --}}
                                        <div x-show="searchOpen && filteredProducts.length === 0"
                                             class="absolute z-50 mt-1.5 w-full bg-white border border-slate-100 shadow-xl rounded-xl p-4 text-center text-xs text-slate-400"
                                             style="display: none;">
                                            Produk ATK tidak ditemukan.
                                        </div>

                                        {{-- Info Badge Stok Jika Produk Sudah Terpilih Sempurna --}}
                                        <div x-show="selectedProductData" x-transition class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                                            <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                            Stok Toko: <strong x-text="selectedProductData?.stok + ' pcs'"></strong>
                                            &nbsp;·&nbsp; Harga: <strong x-text="selectedProductData ? formatRupiah(selectedProductData.harga) : ''"></strong>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        {{-- 2. Jumlah Beli --}}
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                                Jumlah Beli (Qty) <span class="text-red-400">*</span>
                                            </label>
                                            <div class="flex items-center border rounded-xl overflow-hidden {{ $errors->has('jumlah') ? 'border-red-300' : 'border-slate-200' }}">
                                                <button type="button" @click="if(qty > 1) qty--"
                                                        class="w-11 h-11 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xl transition border-r border-slate-200">−</button>
                                                <input type="number" name="jumlah" x-model.number="qty"
                                                       :max="maxStok" min="1" required
                                                       class="flex-1 h-11 text-center font-extrabold text-slate-800 text-base focus:outline-none border-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                                <button type="button" @click="if(qty < maxStok) qty++"
                                                        class="w-11 h-11 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xl transition border-l border-slate-200">+</button>
                                            </div>
                                        </div>

                                        {{-- 3. Nama Pembeli --}}
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                                Nama Pembeli Offline <span class="text-red-400">*</span>
                                            </label>
                                            <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required
                                                   placeholder="Contoh: Bu Endang Blok C"
                                                   class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition border-slate-200">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        {{-- 4. Metode Bayar --}}
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                                Metode Pembayaran <span class="text-red-400">*</span>
                                            </label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <label :class="payment === 'cash' ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-500/20' : 'border-slate-200 hover:bg-slate-50'"
                                                       class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all">
                                                    <input type="radio" name="metode_bayar" value="cash" x-model="payment" class="w-4 h-4 text-blue-600 border-slate-300">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-900">Cash</p>
                                                        <p class="text-[10px] text-slate-400">Bayar tunai</p>
                                                    </div>
                                                </label>
                                                <label :class="payment === 'hutang' ? 'border-amber-400 bg-amber-50 ring-2 ring-amber-400/20' : 'border-slate-200 hover:bg-slate-50'"
                                                       class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all">
                                                    <input type="radio" name="metode_bayar" value="hutang" x-model="payment" class="w-4 h-4 text-amber-500 border-slate-300">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-900">Hutang</p>
                                                        <p class="text-[10px] text-slate-400">Catat bon</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        {{-- 5. Metode Penyerahan --}}
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                                Metode Penyerahan <span class="text-red-400">*</span>
                                            </label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <label :class="delivery === 'ambil' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-500/20' : 'border-slate-200 hover:bg-slate-50'"
                                                       class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all">
                                                    <input type="radio" name="tipe_penyerahan" value="ambil" x-model="delivery" class="w-4 h-4 text-indigo-600 border-slate-300">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-900">Di Konter</p>
                                                        <p class="text-[10px] text-slate-400">Ambil sendiri</p>
                                                    </div>
                                                </label>
                                                <label :class="delivery === 'antar' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-500/20' : 'border-slate-200 hover:bg-slate-50'"
                                                       class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition-all">
                                                    <input type="radio" name="tipe_penyerahan" value="antar" x-model="delivery" class="w-4 h-4 text-indigo-600 border-slate-300">
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-900">Diantar</p>
                                                        <p class="text-[10px] text-slate-400">Kurir toko</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 6. Catatan / Alamat --}}
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                            Catatan / Alamat Rumah <span class="normal-case font-normal text-slate-300 ml-1">(opsional)</span>
                                        </label>
                                        <textarea name="catatan" rows="3"
                                                  :placeholder="delivery === 'antar' ? 'Tulis alamat lengkap pembeli. Contoh: Perum Pangauban Silih Asih, Blok L No. 10.' : 'Contoh: Pembeli minta disiapkan, diambil sepulang sekolah...'"
                                                  class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none transition">{{ old('catatan') }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- RIGHT: Ringkasan & Submit --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-4">
                            <div class="px-6 py-4 border-b border-slate-50">
                                <h3 class="text-sm font-bold text-slate-900">Ringkasan Transaksi</h3>
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Produk</span>
                                    <span class="font-semibold text-slate-700 text-right max-w-[140px] truncate"
                                          x-text="selectedProductData?.nama ?? '—'">—</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Harga Satuan</span>
                                    <span class="font-semibold text-slate-700"
                                          x-text="selectedProductData ? formatRupiah(selectedProductData.harga) : '—'">—</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Jumlah</span>
                                    <span class="font-semibold text-slate-700" x-text="qty + ' pcs'">1 pcs</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Penyerahan</span>
                                    <span class="font-semibold text-slate-700"
                                          x-text="delivery === 'ambil' ? 'Ambil di Konter' : 'Diantar Kurir'">Ambil di Konter</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Pembayaran</span>
                                    <span class="font-semibold"
                                          :class="payment === 'hutang' ? 'text-amber-600' : 'text-emerald-600'"
                                          x-text="payment === 'cash' ? 'Cash / Tunai' : 'Hutang / Bon'">Cash</span>
                                </div>

                                <div class="border-t border-dashed border-slate-100 pt-3 flex justify-between items-center">
                                    <span class="font-bold text-slate-900 text-sm">Total</span>
                                    <span class="text-xl font-extrabold text-blue-700"
                                          x-text="selectedProductData ? formatRupiah(totalHarga) : 'Rp —'">Rp —</span>
                                </div>

                                <div class="flex items-center gap-2 bg-emerald-50 rounded-xl p-3 border border-emerald-100">
                                    <p class="text-xs text-emerald-700 font-medium">Status otomatis <strong>Selesai</strong> & stok terpotong.</p>
                                </div>

                                <div x-show="selectedProductData && qty > maxStok" x-transition
                                     class="flex items-center gap-2 bg-red-50 rounded-xl p-3 border border-red-100" style="display: none;">
                                    <p class="text-xs text-red-700 font-medium">Jumlah melebihi stok tersedia!</p>
                                </div>

                                {{-- Container Utama Modal Konfirmasi Simpan dengan Alpine.js --}}
                                <div x-data="{ openSaveModal: false }">

                                    {{-- 1. Tombol Pemicu Utama (Yang tampil di ringkasan kanan) --}}
                                    <button type="button"
                                            @click="openSaveModal = true"
                                            :disabled="!selectedProductData || qty < 1 || qty > maxStok"
                                            class="w-full flex items-center justify-center gap-2 py-3.5 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 transition active:scale-[0.98]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Simpan & Potong Stok
                                    </button>

                                    {{-- 2. Pop-up Modal Konfirmasi Berwarna Tema Biru POS --}}
                                    <div x-show="openSaveModal"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                                        style="display: none;">

                                        {{-- Kotak Putih Modal --}}
                                        <div @click.away="openSaveModal = false"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-xl space-y-4 text-left">

                                            {{-- Konten Informasi --}}
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-base font-bold text-slate-900">Simpan Transaksi</h3>
                                                    <p class="text-xs text-slate-400 mt-0.5">Simpan transaksi offline ini? Stok fisik barang di database akan otomatis langsung dikurangi.</p>
                                                </div>
                                            </div>

                                            {{-- Tombol Pilihan Aksi --}}
                                            <div class="grid grid-cols-2 gap-3 pt-2">
                                                {{-- Tombol Batal --}}
                                                <button type="button"
                                                        @click="openSaveModal = false"
                                                        class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                    Batal
                                                </button>

                                                {{-- Tombol Submit Asli (Menembak form manualForm menggunakan JavaScript native) --}}
                                                <button type="submit"
                                                        form="manualForm"
                                                        class="h-10 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition rounded-xl shadow-md shadow-blue-500/10">
                                                    Ya, Simpan
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>
