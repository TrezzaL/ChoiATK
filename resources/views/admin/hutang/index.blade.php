<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Hutang — Panel Admin ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-800 antialiased">
<div class="flex h-screen overflow-hidden">

    {{-- Sesuaikan nama komponen sidebar admin milikmu --}}
    <x-sidebar-admin/>

    <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
        {{-- Sesuaikan nama komponen navbar admin milikmu --}}
        <x-navbar-admin/>

        <main class="p-6 md:p-8 space-y-6 animate-page-load">

            {{-- Header --}}
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Buku Hutang Pelanggan</h2>
                <p class="text-sm text-slate-500 mt-1">Rekapitulasi seluruh catatan bon/hutang pelanggan yang belum lunas.</p>
            </div>

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                     class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm text-sm">
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Ringkasan Total Kas Bon --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 flex items-center gap-4 shadow-sm max-w-md">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.214-.116M6 8.636l.214-.116M6 12.364l.214-.116M6 16.091l.214-.116M18 8.636l-.214-.116M18 12.364l-.214-.116M18 16.091l-.214-.116M15 19.364l-.214-.116" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Piutang Toko</p>
                    <p class="text-2xl font-extrabold text-amber-500 mt-0.5">Rp {{ number_format($grandTotalHutang, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 pl-6">Pelanggan</th>
                                <th class="p-4">Item Produk</th>
                                <th class="p-4">Tanggal Bon</th>
                                <th class="p-4">Total Hutang</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                            @forelse($daftarHutang as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    {{-- Info Pelanggan --}}
                                    <td class="p-4 pl-6">
                                        <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $order->user->phone ?? 'Tidak ada No. HP' }}</p>
                                    </td>
                                    {{-- Info Produk --}}
                                    <td class="p-4">
                                        <p class="font-semibold text-slate-800">{{ $order->product->nama }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $order->jumlah }} pcs &times; Rp {{ number_format($order->product->harga, 0, ',', '.') }}</p>
                                    </td>
                                    {{-- Tanggal --}}
                                    <td class="p-4 text-xs font-medium text-slate-500">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </td>
                                    {{-- Total Nominal --}}
                                    <td class="p-4 font-extrabold text-red-600">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    {{-- Tombol Tindakan Lunas --}}
                                    <td class="p-4 text-center">
                                        {{-- Container Utama Modal Pelunasan Alpine.js --}}
                                        <div x-data="{ openLunasModal: false }">

                                            {{-- 1. Tombol Pemicu Utama (Di dalam tabel hutang) --}}
                                            <button type="button"
                                                    @click="openLunasModal = true"
                                                    class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow-sm shadow-emerald-500/10">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Set Lunas
                                            </button>

                                            {{-- 2. Pop-up Modal Konfirmasi Pelunasan (Dilemparkan ke Body) --}}
                                            <template x-teleport="body">
                                                <div x-show="openLunasModal"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                                    style="display: none;">

                                                    {{-- Kotak Putih Modal --}}
                                                    <div @click.away="openLunasModal = false"
                                                        x-transition:enter="transition ease-out duration-300"
                                                        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                        class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-2xl space-y-4">

                                                        {{-- Konten Informasi Pelunasan --}}
                                                        <div class="flex items-start gap-3 text-left">
                                                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0 mt-0.5">
                                                                {{-- Ikon Uang/Ceklis --}}
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                                                </svg>
                                                            </div>
                                                            <div class="text-left">
                                                                <h3 class="text-base font-bold text-slate-900">Konfirmasi Pelunasan Bon</h3>
                                                                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                                                                    Apakah pelanggan pesanan <span class="font-bold text-slate-800">#{{ $order->id }}</span> ini sudah membayar lunas tagihannya?
                                                                    <span class="inline-block mt-1.5 text-emerald-700 font-medium bg-emerald-50 py-1 px-2 rounded border border-emerald-100">
                                                                        Pastikan uang fisik sudah diterima di kasir.
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        {{-- Tombol Pilihan Aksi --}}
                                                        <div class="grid grid-cols-2 gap-3 pt-2">
                                                            {{-- Tombol Batal --}}
                                                            <button type="button"
                                                                    @click="openLunasModal = false"
                                                                    class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                                Batal
                                                            </button>

                                                            {{-- Form Native POST Laravel --}}
                                                            <form method="POST" action="{{ route('admin.hutang.lunaskan', $order) }}" class="m-0 p-0">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="w-full h-10 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition rounded-xl shadow-md shadow-emerald-500/10">
                                                                    Ya, Sudah Lunas
                                                                </button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-slate-400">
                                        <span class="text-sm font-semibold block">Buku bon kosong murni!</span>
                                        <span class="text-xs text-slate-300 mt-0.5">Semua pelanggan tertib membayar cash. bagus!</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
</body>
</html>
