<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog ATK — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-pelanggan/>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-pelanggan/>

            <main class="p-6 md:p-8 space-y-6 animate-page-load">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Katalog ATK</h2>
                        <p class="text-sm text-slate-500 mt-1">Temukan kebutuhan alat tulis kantor terbaik untuk kamu.</p>
                    </div>
                    <a href="{{ route('pelanggan.cart.index') }}"
                       class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-blue-300 text-slate-700 hover:text-blue-700 px-4 py-2 rounded-xl text-sm font-semibold shadow-sm transition self-start sm:self-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        Keranjang Saya
                    </a>
                </div>

                {{-- Filter & Search Form --}}
                <form method="GET" action="{{ route('pelanggan.katalog') }}"
                    class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm flex gap-3 flex-wrap items-center">

                    {{-- Kolom Input Search (Live Search dengan Alpine.js) --}}
                    <div class="relative flex-1 min-w-48" x-data>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk ATK..."
                            @input.debounce.750ms="$el.closest('form').submit()"
                            {{ request('search') ? 'autofocus onfocus="this.setSelectionRange(this.value.length, this.value.length);"' : '' }}
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                    </div>

                    {{-- Filter Kategori (Custom Dropdown Alpine.js) --}}
                    @php
                        $selectedCategoryId = request('category_id', '');
                        $selectedCategoryName = 'Semua Kategori';

                        // Cek apakah ada kategori yang sedang di-filter di URL
                        if ($selectedCategoryId) {
                            $currentCat = $categories->firstWhere('id', $selectedCategoryId);
                            if ($currentCat) {
                                $selectedCategoryName = $currentCat->nama;
                            }
                        }
                    @endphp

                    <div class="relative min-w-48"
                        x-data="{
                            open: false,
                            selectedId: '{{ $selectedCategoryId }}',
                            selectedName: '{{ $selectedCategoryName }}',
                            selectOption(id, name) {
                                this.selectedId = id;
                                this.selectedName = name;
                                this.open = false;

                                // Auto-submit form begitu kategori dipilih
                                $nextTick(() => {
                                    $el.closest('form').submit();
                                });
                            }
                        }"
                        @click.away="open = false">

                        {{-- Input Hidden pengganti <select> untuk dikirim ke Controller --}}
                        <input type="hidden" name="category_id" :value="selectedId">

                        {{-- Tombol Utama Dropdown --}}
                        <button type="button"
                                @click="open = !open"
                                class="h-[42px] w-full px-4 flex items-center justify-between rounded-xl border text-sm font-medium bg-white transition-all duration-200 focus:outline-none"
                                :class="open ? 'border-blue-500 ring-4 ring-blue-100/50 text-slate-900' : 'border-slate-200 text-slate-700 hover:border-blue-300'">

                            <span x-text="selectedName"></span>

                            {{-- Ikon Panah Berputar --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                :class="open ? 'rotate-180 text-blue-500' : ''"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- List Menu Pilihan Kategori --}}
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute left-0 z-30 mt-2 w-full bg-white rounded-xl border border-slate-100 shadow-xl py-1 overflow-hidden focus:outline-none"
                            style="display: none;">

                            {{-- Opsi Default: Semua Kategori --}}
                            <button type="button"
                                    @click="selectOption('', 'Semua Kategori')"
                                    class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between"
                                    :class="selectedId === '' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'">
                                <span>Semua Kategori</span>
                                <svg x-show="selectedId === ''" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>

                            {{-- Perulangan Data Kategori dari Database --}}
                            @foreach($categories as $category)
                                <button type="button"
                                        @click="selectOption('{{ $category->id }}', '{{ $category->nama }}')"
                                        class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between"
                                        :class="selectedId == '{{ $category->id }}' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'">
                                    <span>{{ $category->nama }}</span>

                                    {{-- Ikon Ceklis Opsi Terpilih --}}
                                    <svg x-show="selectedId == '{{ $category->id }}'" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tombol Reset (Hanya Muncul Jika Sedang Mencari/Filter) --}}
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('pelanggan.katalog') }}"
                            class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2.5 rounded-xl text-sm font-bold border border-red-100 transition">
                            Hapus Filter
                        </a>
                    @endif

                </form>

                {{-- Hasil pencarian --}}
                @if(request('search'))
                    <p class="text-sm text-slate-500">
                        Hasil pencarian untuk
                        <span class="font-bold text-slate-800">"{{ request('search') }}"</span>
                        — <span class="text-blue-600 font-semibold">{{ $products->count() }} produk</span> ditemukan
                    </p>
                @endif

                {{-- Grid Produk --}}
                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-slate-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <p class="text-slate-700 font-bold">Produk tidak ditemukan</p>
                        <p class="text-slate-400 text-sm mt-1">Coba kata kunci lain atau pilih kategori berbeda</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($products as $product)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col group">

                            {{-- Foto Produk --}}
                            <div class="relative overflow-hidden">
                                @if($product->foto)
                                    <img src="{{ asset('storage/' . $product->foto) }}"
                                        class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-44 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-blue-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                        </svg>
                                    </div>
                                @endif
                                {{-- Stock badge --}}
                                @if($product->stok > 0 && $product->stok <= ($product->stok_minimum ?? 5))
                                    <div class="absolute top-2 right-2">
                                        <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">Hampir Habis</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Info Produk --}}
                            <div class="p-4 flex flex-col flex-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-100 mb-2 w-fit">
                                    {{ $product->category->nama }}
                                </span>

                                <p class="font-bold text-slate-800 text-sm leading-tight mb-1 group-hover:text-blue-700 transition-colors">
                                    {{ $product->nama }}
                                </p>

                                @if($product->deskripsi)
                                    <p class="text-xs text-slate-400 mb-3 line-clamp-2 leading-relaxed">
                                        {{ $product->deskripsi }}
                                    </p>
                                @endif

                                <div class="mt-auto">
                                    <div class="flex items-end justify-between mb-3">
                                        <p class="text-blue-700 font-extrabold text-base">
                                            {{ $product->hargaFormatted() }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            Stok: <span class="font-semibold {{ $product->stok == 0 ? 'text-red-500' : 'text-slate-600' }}">{{ $product->stok }}</span>
                                        </p>
                                    </div>

                                    @if($product->stok > 0)
                                        <div class="flex gap-2">
                                            <button type="button"
                                                onclick="openCartModal('{{ $product->id }}', '{{ $product->nama }}', '{{ $product->stok }}', '{{ $product->hargaFormatted() }}')"
                                                title="Masukkan Keranjang"
                                                class="flex items-center justify-center p-2.5 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl border border-blue-100 hover:border-blue-600 transition-all duration-150 group/btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                            </button>

                                            <a href="{{ route('pelanggan.order.create', ['product_id' => $product->id]) }}"
                                                class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-bold transition shadow-sm shadow-blue-500/20 active:scale-[0.98]">
                                                Pesan Sekarang
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center gap-2 w-full py-2.5 bg-slate-50 border border-slate-100 text-slate-400 rounded-xl text-sm font-semibold cursor-not-allowed">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Stok Habis
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            </main>
        </div>
    </div>

    {{-- MODAL INTERAKTIF KUANTITAS KERANJANG --}}
    <div id="cartModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-base font-bold text-slate-900">Tambah ke Keranjang</h3>
                <button type="button" onclick="closeCartModal()" class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-blue-50/50 rounded-xl p-4 mb-5 border border-blue-100">
                <p id="modalProductName" class="font-bold text-sm text-slate-800 truncate"></p>
                <div class="flex justify-between items-center mt-2">
                    <span id="modalProductPrice" class="text-base font-extrabold text-blue-700"></span>
                    <span id="modalProductStock" class="text-xs text-slate-400 font-medium"></span>
                </div>
            </div>

            <form id="asyncCartForm" action="{{ route('pelanggan.cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Jumlah Beli</label>
                    <div class="flex items-center gap-3 justify-center">
                        <button type="button" onclick="decrementQty()"
                            class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-slate-600 transition text-lg">
                            −
                        </button>
                        <input type="number" name="quantity" id="modalQtyInput" value="1" min="1"
                            class="w-20 text-center font-extrabold text-slate-800 text-xl focus:outline-none border-b-2 border-blue-500 bg-transparent [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" onclick="incrementQty()"
                            class="w-10 h-10 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold text-slate-600 transition text-lg">
                            +
                        </button>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="closeCartModal()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3 rounded-xl text-sm font-bold transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl text-sm font-bold transition shadow-md shadow-blue-500/20">
                        Masukkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ELEMEN TOAST NOTIFICATION FLOATING --}}
    <div id="toastNotification" class="fixed bottom-5 right-5 z-50 flex items-center bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl space-x-3 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-green-500 p-1 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <p id="toastMessage" class="text-xs font-semibold tracking-wide"></p>
    </div>

    {{-- LOGIKAJAVASCRIPT UNTUK MODAL & AJAX --}}
    <script>
        let maxStock = 1;

        function openCartModal(id, name, stock, price) {
            maxStock = parseInt(stock);

            // Set data ke komponen modal
            document.getElementById('modalProductId').value = id;
            document.getElementById('modalProductName').innerText = name;
            document.getElementById('modalProductPrice').innerText = price;
            document.getElementById('modalProductStock').innerText = 'Stok: ' + stock;

            const qtyInput = document.getElementById('modalQtyInput');
            qtyInput.value = 1;
            qtyInput.setAttribute('max', stock);

            // Munculkan Modal dengan animasi flex
            const modal = document.getElementById('cartModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.firstElementChild.classList.remove('scale-95');
                modal.firstElementChild.classList.add('scale-100');
            }, 10);
        }

        function closeCartModal() {
            const modal = document.getElementById('cartModal');
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 150);
        }

        function incrementQty() {
            const input = document.getElementById('modalQtyInput');
            let current = parseInt(input.value);
            if (current < maxStock) {
                input.value = current + 1;
            }
        }

        function decrementQty() {
            const input = document.getElementById('modalQtyInput');
            let current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // VALIDASI INPUT MANUAL BIAR GAK MELEBIHI STOK ATAU COBA MINUS
        document.getElementById('modalQtyInput').addEventListener('change', function() {
            let val = parseInt(this.value);
            if (isNaN(val) || val < 1) this.value = 1;
            if (val > maxStock) this.value = maxStock;
        });

        // PROSES SUBMIT KERANJANG VIA AJAX TANPA RELOAD HALAMAN
        document.getElementById('asyncCartForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Tutup modal duluan biar smooth
                closeCartModal();

                // Trigger Toast Notifikasi Sukses
                const productName = document.getElementById('modalProductName').innerText;
                const qty = document.getElementById('modalQtyInput').value;
                showToast(`${qty}x ${productName} berhasil masuk keranjang!`);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal menambahkan ke keranjang', true);
            });
        });

        function showToast(message, isError = false) {
            const toast = document.getElementById('toastNotification');
            const toastMsg = document.getElementById('toastMessage');

            toastMsg.innerText = message;

            // Animasi memunculkan toast
            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Sembunyikan otomatis setelah 3.5 detik
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            }, 3500);
        }
    </script>
</body>
</html>
