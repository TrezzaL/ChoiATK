<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">

    <x-sidebar-pelanggan/>

    <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
        <x-navbar-pelanggan/>

        <main class="p-6 md:p-8 space-y-6">

            {{-- Header --}}
            <div>
                <a href="{{ route('pelanggan.katalog') }}"
                   class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Kembali ke Katalog
                </a>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Pesanan</h2>
                <p class="text-sm text-slate-500 mt-1">Isi detail pesanan di bawah ini, kemudian konfirmasi.</p>
            </div>

            {{-- Error Flash --}}
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-100 text-red-700 px-5 py-4 rounded-2xl text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-red-500 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Reaktif State Master lewat Alpine --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start"
                 x-data="{
                     qty: 1,
                     maxQty: {{ $product->stok }},
                     payment: 'cash',
                     delivery: 'ambil',
                     hargaSatuan: {{ $product->harga }},
                     get totalHarga() {
                         return this.hargaSatuan * this.qty;
                     },
                     get bisaDiantar() {
                         return this.totalHarga >= 10000;
                     },
                     init() {
                         // Watcher reaktif untuk reset opsi penyerahan jika total harga drop di bawah 10.000
                         $watch('qty', value => {
                             if(this.totalHarga < 10000) {
                                 this.delivery = 'ambil';
                             }
                         });
                     }
                 }">

                {{-- LEFT: Product Info + Form --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Product Card --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900">Produk yang Dipesan</h3>
                        </div>
                        <div class="p-6 flex items-center gap-5">
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 flex items-center justify-center shrink-0">
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100 mb-2">
                                    {{ $product->category->nama ?? 'ATK' }}
                                </span>
                                <h4 class="font-bold text-slate-900 text-lg leading-tight">{{ $product->nama }}</h4>
                                @if($product->deskripsi)
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed line-clamp-2">{{ $product->deskripsi }}</p>
                                @endif
                                <div class="flex items-center gap-4 mt-3">
                                    <div>
                                        <p class="text-xs text-slate-400 font-semibold mb-0.5">Harga / pcs</p>
                                        <p class="text-base font-extrabold text-blue-700">{{ $product->hargaFormatted() }}</p>
                                    </div>
                                    <div class="w-px h-8 bg-slate-100"></div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-semibold mb-0.5">Stok Tersedia</p>
                                        <p class="text-base font-extrabold text-slate-800">{{ $product->stok }} <span class="text-xs font-medium text-slate-400">pcs</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form input utama --}}
                    <form method="POST" action="{{ route('pelanggan.order.store') }}" id="orderForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Detail Pesanan</h3>
                            </div>

                            <div class="p-6 space-y-6">

                                {{-- Jumlah Beli --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Jumlah Beli</label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-white">
                                            <button type="button"
                                                @click="if(qty > 1) { qty-- }"
                                                class="w-11 h-11 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xl transition border-r border-slate-200">
                                                −
                                            </button>
                                            <input type="number" name="jumlah" x-model.number="qty"
                                                min="1" :max="maxQty" required
                                                class="w-16 h-11 text-center font-extrabold text-slate-800 text-base focus:outline-none focus:ring-0 border-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                            <button type="button"
                                                @click="if(qty < maxQty) { qty++ }"
                                                class="w-11 h-11 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold text-xl transition border-l border-slate-200">
                                                +
                                            </button>
                                        </div>
                                        <div class="text-sm text-slate-500">
                                            dari <span class="font-bold text-slate-800">{{ $product->stok }}</span> stok tersedia
                                        </div>
                                    </div>
                                </div>

                                {{-- Metode Bayar --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Metode Pembayaran</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label :class="payment === 'cash' ? 'border-blue-500 bg-blue-50/40 ring-2 ring-blue-500/10' : 'border-slate-200 hover:bg-slate-50'"
                                               class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all duration-150">
                                            <input type="radio" name="metode_bayar" value="cash" x-model="payment" class="mt-0.5 w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">Cash / Tunai</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Bayar langsung di toko atau saat COD</p>
                                            </div>
                                        </label>
                                        <label :class="payment === 'hutang' ? 'border-amber-400 bg-amber-50/40 ring-2 ring-amber-400/10' : 'border-slate-200 hover:bg-slate-50'"
                                               class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all duration-150">
                                            <input type="radio" name="metode_bayar" value="hutang" x-model="payment" class="mt-0.5 w-4 h-4 text-amber-500 border-slate-300 focus:ring-amber-400">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">Hutang / Bon</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Dicatat ke buku hutang</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                {{-- FITUR BARU: Opsi Tipe Penyerahan Produk --}}
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Metode Penyerahan</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        {{-- Ambil Sendiri --}}
                                        <label :class="delivery === 'ambil' ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-500/10' : 'border-slate-200 hover:bg-slate-50'"
                                            class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all duration-150">
                                            <input type="radio" name="tipe_penyerahan" value="ambil" x-model="delivery" class="mt-0.5 w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">Ambil Sendiri</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Ambil mandiri ke konter toko</p>
                                            </div>
                                        </label>

                                        {{-- Diantar Berbasis Validasi Minimum Pembelian --}}
                                        <label :class="!bisaDiantar ? 'opacity-50 bg-slate-50 border-dashed cursor-not-allowed' : (delivery === 'antar' ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-500/10' : 'border-slate-200 hover:bg-slate-50')"
                                            class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all duration-150 relative">
                                            <input type="radio" name="tipe_penyerahan" value="antar" x-model="delivery" :disabled="!bisaDiantar" class="mt-0.5 w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500 disabled:opacity-50">
                                            <div>
                                                <p class="text-sm font-bold text-slate-900">Diantar Kurir</p>
                                                <p class="text-xs text-slate-400 mt-0.5">Kirim ke lokasi (Min. Rp 10.000)</p>
                                            </div>
                                        </label>
                                    </div>

                                    {{-- Banner Peringatan Reaktif Jika Kurang dari Rp 10.000 --}}
                                    <div x-show="!bisaDiantar" x-transition class="mt-2.5 bg-amber-50 border border-amber-100 rounded-xl px-4 py-2.5 text-xs text-amber-700 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-500 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <span>Opsi pengantaran terkunci. Tambah jumlah beli hingga total minimal <strong>Rp 10.000</strong> agar kurir bisa diantar.</span>
                                    </div>

                                    {{-- ALERT BARU: Wilayah Pengantaran Maksimal Perumahan Pangauban Silih Asih --}}
                                    <div x-show="delivery === 'antar' && bisaDiantar" x-transition class="mt-2.5 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-xs text-blue-800 space-y-1">
                                        <div class="flex items-center gap-2 font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-blue-600 shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.083 1.083l-.02.041m-1.104-1.104l.02-.041m1.104 1.104l-.041.02M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            <span>Informasi Wilayah Pengantaran</span>
                                        </div>
                                        <p class="pl-6 leading-relaxed text-slate-600">
                                            Pengantaran kurir hanya melayani area <strong class="text-slate-900">Perumahan Pangauban Silih Asih</strong> (Maks. 2 KM). Jika lokasi Anda berada di luar area tersebut, harap hubungi Admin terlebih dahulu melalui WhatsApp <strong class="text-blue-700">0812-1319-2110</strong> sebelum mengirim pesanan.
                                        </p>
                                    </div>
                                </div>

                                {{-- Catatan --}}
                                <div>
                                    <label for="catatan" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                                        Catatan & Alamat Kirim <span class="normal-case font-medium text-slate-300">(wajib isi jika diantar)</span>
                                    </label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-300 resize-none transition"
                                        :placeholder="delivery === 'antar'
                                            ? 'TULIS ALAMAT BLOK/NO RUMAH ANDA DISINI! Contoh: Perum Pangauban Silih Asih, Blok L No. 10.'
                                            : 'Contoh: Tolong disiapkan besok pagi di lobi depan...'"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- RIGHT: Summary Card --}}
                <div class="space-y-4">
                    {{-- Ringkasan --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-4">
                        <div class="px-6 py-5 border-b border-slate-50">
                            <h3 class="font-bold text-slate-900 text-sm">Ringkasan Pesanan</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between text-sm text-slate-500">
                                <span>Produk</span>
                                <span class="font-semibold text-slate-700 truncate max-w-[140px] text-right">{{ $product->nama }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-500">
                                <span>Harga Satuan</span>
                                <span class="font-semibold text-slate-700">{{ $product->hargaFormatted() }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-500">
                                <span>Jumlah</span>
                                <span class="font-semibold text-slate-700" x-text="qty + ' pcs'">1 pcs</span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-500 border-t border-slate-50 pt-2.5">
                                <span>Penyerahan</span>
                                <span class="font-semibold text-slate-700" x-text="delivery === 'ambil' ? 'Ambil Sendiri' : 'Diantar Kurir'">Ambil Sendiri</span>
                            </div>

                            <div class="border-t border-dashed border-slate-100 pt-4 flex justify-between items-center">
                                <span class="font-bold text-slate-900">Total</span>
                                <span class="text-xl font-extrabold text-blue-700" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')">
                                    {{ $product->hargaFormatted() }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2.5 bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-emerald-500 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                <p class="text-xs text-slate-500 leading-relaxed">Pesanan aman, terpercaya, dan dapat diverifikasi admin ChoiATK.</p>
                            </div>

                            <button type="submit" form="orderForm"
                                class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition active:scale-[0.98]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                                Kirim Pesanan
                            </button>

                            <a href="{{ route('pelanggan.katalog') }}"
                               class="block text-center text-xs font-semibold text-slate-400 hover:text-blue-600 transition py-1">
                                Batal & kembali ke katalog
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>
</body>
</html>
