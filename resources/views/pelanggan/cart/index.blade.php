<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Keranjang Belanja</h2>
                    <p class="text-sm text-slate-500 mt-1">Kelola produk ATK yang ingin kamu beli.</p>
                </div>

                {{-- Toast Sukses Otomatis --}}
                @if(session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition
                         class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-3.5 rounded-2xl shadow-sm text-sm">
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if($cartItems->isEmpty())
                    {{-- Empty State --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-slate-700">Keranjang masih kosong</p>
                        <p class="text-sm text-slate-400 mt-1 mb-6">Yuk, temukan kebutuhan ATK kamu di katalog!</p>
                        <a href="{{ route('pelanggan.katalog') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18" />
                            </svg>
                            Lihat Katalog ATK
                        </a>
                    </div>

                @else
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                        {{-- Cart Items --}}
                        <div class="lg:col-span-2 space-y-3">
                            @foreach($cartItems as $item)
                                {{-- Alpine Component Per Item Keranjang --}}
                                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col sm:flex-row gap-4 items-center hover:shadow-md transition-shadow group"
                                     x-data="{
                                         qty: {{ $item->quantity }},
                                         harga: {{ $item->product->harga }},
                                         get subtotal() { return this.qty * this.harga }
                                     }">

                                    {{-- Product Image --}}
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-blue-50 border border-blue-100 shrink-0">
                                        @if($item->product->foto)
                                            <img src="{{ asset('storage/' . $item->product->foto) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8 text-blue-300">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="flex-1 min-w-0 text-center sm:text-left">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-semibold border border-blue-100 mb-1.5">
                                            {{ $item->product->category->nama ?? 'ATK' }}
                                        </span>
                                        <h4 class="font-bold text-slate-800 text-sm truncate group-hover:text-blue-700 transition">
                                            {{ $item->product->nama }}
                                        </h4>
                                        <p class="text-sm font-bold text-blue-600 mt-1">
                                            {{ $item->product->hargaFormatted() }}
                                        </p>
                                    </div>

                                    {{-- Qty + Total + Delete --}}
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0">

                                        {{-- Update Qty Tanpa Tombol OK (Auto-Submit via Event Change) --}}
                                        <form action="{{ route('pelanggan.cart.update', $item->id) }}" method="POST" id="form-qty-{{ $item->id }}" class="flex items-center">
                                            @csrf @method('PUT')
                                            <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                                                {{-- Tombol Minus Manual --}}
                                                <button type="button"
                                                        @click="if(qty > 1) { qty--; $nextTick(() => $el.form.submit()) }"
                                                        class="w-9 h-9 flex items-center justify-center font-bold text-slate-500 hover:bg-slate-200 transition">
                                                    −
                                                </button>

                                                {{-- Input Number Reaktif --}}
                                                <input type="number" name="quantity" x-model.number="qty" min="1" max="{{ $item->product->stok }}"
                                                       @change="$el.form.submit()"
                                                       class="w-12 text-center text-sm font-extrabold text-slate-800 border-none bg-white focus:outline-none p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">

                                                {{-- Tombol Plus Manual --}}
                                                <button type="button"
                                                        @click="if(qty < {{ $item->product->stok }}) { qty++; $nextTick(() => $el.form.submit()) }"
                                                        class="w-9 h-9 flex items-center justify-center font-bold text-slate-500 hover:bg-slate-200 transition">
                                                    +
                                                </button>
                                            </div>
                                        </form>

                                        {{-- Subtotal (Dihitung Instan Lewat Alpine.js) --}}
                                        <div class="text-right min-w-[100px]">
                                            <p class="text-sm font-extrabold text-slate-900">
                                                Rp <span x-text="subtotal.toLocaleString('id-ID')"></span>
                                            </p>
                                            <p class="text-[10px] text-slate-400"><span x-text="qty"></span> pcs</p>
                                        </div>

                                        {{-- Delete --}}
                                        {{-- Container Utama Modal Hapus Item Keranjang --}}
                                        <div x-data="{ openDeleteCartModal: false }">

                                            {{-- 1. Tombol Pemicu Utama (Di dalam list keranjang) --}}
                                            <button type="button"
                                                    @click="openDeleteCartModal = true"
                                                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:text-red-500 hover:bg-red-50 border border-transparent hover:border-red-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>

                                            {{-- 2. Pop-up Modal Konfirmasi Hapus (Dilemparkan ke Body) --}}
                                            <template x-teleport="body">
                                                <div x-show="openDeleteCartModal"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                                    style="display: none;">

                                                    {{-- Kotak Putih Modal --}}
                                                    <div @click.away="openDeleteCartModal = false"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                        class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-2xl space-y-4">

                                                        {{-- Konten Informasi Peringatan --}}
                                                        <div class="flex items-center gap-3 text-left">
                                                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shrink-0">
                                                                {{-- Ikon Trash/Warning --}}
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>
                                                            </div>
                                                            <div class="text-left">
                                                                <h3 class="text-base font-bold text-slate-900">Hapus dari Keranjang</h3>
                                                                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Yakin ingin menghapus <span class="font-bold text-slate-700">{{ $item->product->nama ?? 'produk ini' }}</span> dari keranjang belanjamu?</p>
                                                            </div>
                                                        </div>

                                                        {{-- Tombol Pilihan Aksi --}}
                                                        <div class="grid grid-cols-2 gap-3 pt-2">
                                                            {{-- Tombol Batal --}}
                                                            <button type="button"
                                                                    @click="openDeleteCartModal = false"
                                                                    class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                                Batal
                                                            </button>

                                                            {{-- Form Native DELETE Laravel --}}
                                                            <form action="{{ route('pelanggan.cart.destroy', $item->id) }}" method="POST" class="m-0 p-0">
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

                                </div>
                            @endforeach
                        </div>

                        {{-- Order Summary --}}
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-4">
                            <div class="px-6 py-5 border-b border-slate-50">
                                <h3 class="font-bold text-slate-900 text-sm">Ringkasan Belanja</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between text-sm text-slate-500">
                                    <span>Total Barang</span>
                                    <span class="font-semibold text-slate-700">{{ $cartItems->sum('quantity') }} item</span>
                                </div>
                                <div class="flex justify-between text-sm text-slate-500">
                                    <span>Total Jenis Produk</span>
                                    <span class="font-semibold text-slate-700">{{ $cartItems->count() }} jenis</span>
                                </div>
                                <div class="border-t border-dashed border-slate-100 pt-4 flex justify-between items-center">
                                    <span class="font-bold text-slate-900">Total Tagihan</span>
                                    <span class="text-xl font-extrabold text-blue-700">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('pelanggan.checkout') }}"
                                    class="flex items-center justify-center gap-2 w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition active:scale-[0.98]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                    Lanjut ke Pembayaran
                                </a>

                                <a href="{{ route('pelanggan.katalog') }}"
                                    class="block text-center text-xs font-semibold text-slate-500 hover:text-blue-600 transition py-1">
                                    ← Tambah produk lagi
                                </a>
                            </div>
                        </div>

                    </div>
                @endif

            </main>
        </div>
    </div>
</body>
</html>
