<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran — ChoiATK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div>
                    <a href="{{ route('pelanggan.cart.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-600 font-medium transition mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Kembali ke Keranjang
                    </a>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Konfirmasi Pembayaran</h2>
                    <p class="text-sm text-slate-500 mt-1">Periksa kembali pesananmu sebelum mengonfirmasi.</p>
                </div>

                {{-- Checkout Steps Indicator --}}
                <div class="flex items-center gap-2 text-xs font-semibold">
                    <div class="flex items-center gap-1.5 text-blue-600">
                        <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                        <span>Keranjang</span>
                    </div>
                    <div class="flex-1 h-px bg-blue-200 max-w-[60px]"></div>
                    <div class="flex items-center gap-1.5 text-blue-600">
                        <div class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">2</div>
                        <span>Konfirmasi</span>
                    </div>
                    <div class="flex-1 h-px bg-slate-200 max-w-[60px]"></div>
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-[10px] font-bold border border-slate-200">3</div>
                        <span>Selesai</span>
                    </div>
                </div>

                {{-- Main Form Terintegrasi State Alpine + Modal Konfirmasi --}}
                <div x-data="{
                         delivery: 'ambil',
                         payment: 'cash',
                         totalBelanja: {{ $totalBelanja }},
                         confirmModal: false,
                         get bisaDiantar() { return this.totalBelanja >= 10000 }
                     }">

                    <form action="{{ route('pelanggan.checkout.store') }}" method="POST" id="checkoutForm" @submit.prevent="confirmModal = true">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                            {{-- LEFT: Items + Options --}}
                            <div class="lg:col-span-2 space-y-5">

                                {{-- Items List --}}
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">Item yang Dibeli ({{ $cartItems->count() }} produk)</h3>
                                    </div>
                                    <div class="divide-y divide-slate-50">
                                        @foreach($cartItems as $item)
                                            <div class="flex items-center gap-4 px-6 py-4">
                                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-blue-50 border border-blue-100 shrink-0 flex items-center justify-center">
                                                    @if($item->product->foto)
                                                        <img src="{{ asset('storage/' . $item->product->foto) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 text-blue-300">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $item->product->nama }}</h4>
                                                    <p class="text-xs text-slate-400 mt-0.5">{{ $item->quantity }}x &times; Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                                </div>
                                                <span class="text-sm font-extrabold text-slate-900 shrink-0">
                                                    Rp {{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- 1. OPSI PENYERAHAN BARANG --}}
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">1. Metode Pengantaran</h3>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition"
                                                   :class="delivery === 'ambil' ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-500/10' : 'border-slate-200 hover:bg-slate-50'">
                                                <input type="radio" name="metode_pengantaran" value="ambil" x-model="delivery"
                                                    class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Ambil Sendiri</span>
                                                    <span class="text-xs text-slate-400">Ambil mandiri ke toko</span>
                                                </div>
                                            </label>

                                            <label class="flex items-center gap-3 p-4 rounded-xl border transition relative"
                                                   :class="!bisaDiantar ? 'opacity-50 bg-slate-50 border-dashed cursor-not-allowed' : (delivery === 'diantar' ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-500/10' : 'border-slate-200 hover:bg-slate-50')">
                                                <input type="radio" name="metode_pengantaran" value="diantar" x-model="delivery" :disabled="!bisaDiantar"
                                                    class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 disabled:opacity-50">
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Antar ke Rumah</span>
                                                    <span class="text-xs text-slate-400">Min. Belanja Rp 10.000</span>
                                                </div>
                                            </label>
                                        </div>

                                        {{-- Warning Banner Jika Belanjaan Kurang Dari Rp 10.000 --}}
                                        <div x-show="!bisaDiantar" x-cloak x-transition class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 text-xs text-amber-700 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-500 shrink-0">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>
                                            <span>Layanan antar terkunci. Total keranjang belanja Anda saat ini (<strong class="text-slate-900">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</strong>) belum mencapai batas minimal Rp 10.000.</span>
                                        </div>

                                        {{-- Batas Wilayah Pengantaran Lokal (Hanya Muncul Jika Diantar) --}}
                                        <div x-show="delivery === 'diantar' && bisaDiantar" x-cloak x-transition class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-xs text-blue-800 space-y-1">
                                            <div class="flex items-center gap-2 font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-blue-600 shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.083 1.083l-.02.041m-1.104-1.104l.02-.041m1.104 1.104l-.041.02M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span>Informasi Wilayah Pengantaran Kurir</span>
                                            </div>
                                            <p class="pl-6 leading-relaxed text-slate-600">
                                                Layanan kurir eksklusif mengantar ke wilayah <strong class="text-slate-900">Perumahan Pangauban Silih Asih</strong> (Maks. 2 KM). Jika Anda berada di luar area, hubungi WhatsApp Admin di <strong class="text-blue-700">0812-1319-2110</strong> sebelum memesan.
                                            </p>
                                        </div>

                                        {{-- INFORMASI ALAMAT TOKO (Hanya Muncul Jika Ambil Sendiri) --}}
                                        <div x-show="delivery === 'ambil'" x-cloak x-transition class="bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 text-xs text-indigo-800 space-y-1">
                                            <div class="flex items-center gap-2 font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-indigo-600 shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z" />
                                                </svg>
                                                <span>Lokasi Pengambilan Barang (Toko ChoiATK)</span>
                                            </div>
                                            <p class="pl-6 leading-relaxed text-slate-600">
                                                Silakan ambil pesanan Anda langsung di lokasi kami: <strong class="text-slate-900">Perumahan Pangauban Silih Asih Blok L-10, Jl. Mawar, Kec. Batujajar, Kab. Bandung Barat.</strong>
                                            </p>
                                        </div>

                                        {{-- Input Alamat / Catatan Dinamis --}}
                                        <div>
                                            <label id="label-catatan" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                                <span x-text="delivery === 'diantar' ? 'Alamat Lengkap Rumah *' : 'Catatan Tambahan Kasir (Opsional)'"></span>
                                            </label>
                                            <textarea name="catatan" id="catatan" rows="3" required
                                                :placeholder="delivery === 'diantar' ? 'TULIS NOMOR RUMAH / BLOK ANDA. Contoh: Perum Pangauban Silih Asih, Blok C3 No. 12.' : 'Contoh: Tolong barangnya dipisah plastik, diambil sepulang sekolah...'"
                                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-300 resize-none transition"></textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. METODE PEMBAYARAN REAKTIF TEXT --}}
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                                    <div class="px-6 py-4 border-b border-slate-50 flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">2. Metode Pembayaran</h3>
                                    </div>
                                    <div class="p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition"
                                                   :class="payment === 'cash' ? 'border-blue-500 bg-blue-50/40 ring-2 ring-blue-500/10' : 'border-slate-200 hover:bg-slate-50'">
                                                <input type="radio" name="metode_bayar" value="cash" x-model="payment"
                                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300">
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Cash / Tunai</span>
                                                    <span class="text-xs text-slate-400" x-text="delivery === 'ambil' ? 'Bayar cash di meja kasir' : 'Bayar cash di tempat (COD)'"></span>
                                                </div>
                                            </label>

                                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition"
                                                   :class="payment === 'hutang' ? 'border-amber-400 bg-amber-50/40 ring-2 ring-amber-400/10' : 'border-slate-200 hover:bg-slate-50'">
                                                <input type="radio" name="metode_bayar" value="hutang" x-model="payment"
                                                    class="w-4 h-4 text-amber-500 focus:ring-amber-400 border-slate-300">
                                                <div>
                                                    <span class="text-sm font-bold text-slate-900 block">Hutang / Bon</span>
                                                    <span class="text-xs text-slate-400" x-text="delivery === 'ambil' ? 'Ambil barang, catat bon digital' : 'Kurir antar barang, tagihan masuk buku bon'"></span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- RIGHT: Order Summary --}}
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-4">
                                <div class="px-6 py-5 border-b border-slate-50">
                                    <h3 class="font-bold text-slate-900 text-sm">Ringkasan Pembayaran</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div class="flex justify-between text-sm text-slate-500">
                                        <span>Total Item</span>
                                        <span class="font-semibold text-slate-700">{{ $cartItems->sum('quantity') }} pcs</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-slate-500">
                                        <span>Total Jenis Produk</span>
                                        <span class="font-semibold text-slate-700">{{ $cartItems->count() }} jenis</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-slate-500">
                                        <span>Ongkir</span>
                                        <span class="font-semibold text-emerald-600">Gratis (Lokal)</span>
                                    </div>
                                    <div class="border-t border-dashed border-slate-100 pt-4 flex justify-between items-center">
                                        <span class="font-bold text-slate-900">Total Tagihan</span>
                                        <span class="text-xl font-extrabold text-blue-700">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                                    </div>

                                    {{-- Tombol Submit --}}
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition active:scale-[0.98]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Konfirmasi & Buat Pesanan
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>

                    {{-- Modal Konfirmasi Akhir (Alpine.js) --}}
                    <div x-show="confirmModal" class="fixed inset-0 z-[99] flex items-center justify-center overflow-y-auto px-4" style="display: none;" x-cloak>

                        {{-- Backdrop Gelap --}}
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                             x-show="confirmModal"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             @click="confirmModal = false"></div>

                        {{-- Kotak Modal Utama --}}
                        <div class="relative bg-white rounded-2xl p-6 md:p-8 max-w-sm w-full shadow-2xl text-center"
                             x-show="confirmModal"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-8 scale-95">

                            {{-- Ikon Peringatan/Validasi --}}
                            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-5 text-blue-600 border border-blue-100 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 animate-bounce">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <h3 class="text-lg font-black text-slate-900 mb-2 tracking-tight">Apakah Anda Yakin?</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-6 font-medium">
                                Pastikan alamat dan metode pembayaran sudah benar. Setelah tombol ini ditekan, pesanan akan dikirim ke sistem toko dan <strong class="text-slate-800">tidak dapat dibatalkan</strong> oleh pelanggan.
                            </p>

                            {{-- Tombol Aksi --}}
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="confirmModal = false"
                                        class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-sm transition">
                                    Cek Lagi
                                </button>
                                {{-- Tombol Eksekusi Asli yang me-submit form #checkoutForm --}}
                                <button type="button" onclick="document.getElementById('checkoutForm').submit()"
                                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-blue-500/20 active:scale-95">
                                    Ya, Proses!
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>
</body>
</html>
