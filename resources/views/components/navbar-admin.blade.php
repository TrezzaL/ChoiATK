{{-- Premium Topbar Navbar Admin --}}
<nav class="bg-white border-b border-slate-100 px-4 lg:px-6 py-3.5 flex justify-between items-center sticky top-0 z-40 shadow-sm">
    {{-- Left: Hamburger (mobile) + Breadcrumb --}}
    <div class="flex items-center gap-3 text-sm">
        {{-- Hamburger Button — only visible on mobile --}}
        <button onclick="window.dispatchEvent(new CustomEvent('open-sidebar'))"
                class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <span class="text-slate-400 font-medium hidden sm:inline">Admin</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 text-slate-300 hidden sm:inline">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-semibold text-slate-800">
            @if(request()->routeIs('admin.dashboard')) Dashboard
            @elseif(request()->routeIs('admin.category.*')) Kategori
            @elseif(request()->routeIs('admin.product.*')) Produk
            @elseif(request()->routeIs('admin.order*')) Manajemen Order
            @elseif(request()->routeIs('admin.laporan')) Laporan
            @else Panel Admin
            @endif
        </span>
    </div>

    {{-- Right: Actions --}}
    <div class="flex items-center gap-3">

        {{-- Notification Bell --}}
        <div x-data="{ openNotif: false }" class="relative">
            <button @click="openNotif = !openNotif"
                class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-bold h-4 w-4 flex items-center justify-center rounded-full ring-2 ring-white">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            {{-- Notification Dropdown --}}
            <div x-show="openNotif" @click.away="openNotif = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 text-sm max-h-96 overflow-y-auto"
                style="display: none;">
                <div class="px-5 py-3.5 font-bold text-slate-900 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <span class="text-sm">Notifikasi</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }} baru
                        </span>
                    @endif
                </div>
                @if(auth()->user()->notifications->isEmpty())
                    <div class="px-5 py-10 text-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2 text-slate-200">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <p class="text-xs">Belum ada notifikasi</p>
                    </div>
                @else
                    @foreach(auth()->user()->unreadNotifications as $notif)
                        <a href="{{ route('admin.notification.read', $notif->id) }}"
                            class="flex gap-3 px-4 py-3.5 hover:bg-blue-50/40 transition border-b border-slate-50 bg-blue-50/20 items-start">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1 shrink-0"></div>
                            <div>
                                <p class="text-slate-800 font-medium text-xs leading-snug">{{ $notif->data['pesan'] }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                    @foreach(auth()->user()->readNotifications->take(3) as $notif)
                        <a href="{{ route('admin.notification.read', $notif->id) }}"
                            class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition border-b border-slate-50 opacity-50 items-start">
                            <div class="w-2 h-2 rounded-full bg-slate-300 mt-1 shrink-0"></div>
                            <div>
                                <p class="text-slate-600 text-xs leading-snug">{{ $notif->data['pesan'] }}</p>
                                <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Divider --}}
        <div class="w-px h-5 bg-slate-200"></div>

        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2.5 focus:outline-none group">
                <div class="w-9 h-9 bg-blue-600 text-white font-bold rounded-xl flex items-center justify-center text-sm shadow shadow-blue-500/20 group-hover:bg-blue-700 transition">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="hidden md:block text-left">
                    <span class="text-sm font-semibold text-slate-800 block leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-slate-400 font-medium leading-none">Administrator</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition hidden md:block">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                 class="absolute right-0 mt-2.5 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50 text-sm"
                 style="display: none;">
                <div class="px-4 py-3 border-b border-slate-50 bg-slate-50/50">
                    <p class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ auth()->user()->email }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('admin.profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-slate-50 transition text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Edit Profil
                    </a>
                    <div class="border-t border-slate-50 my-1"></div>
                    {{-- Container utama modal konfirmasi menggunakan Alpine.js --}}
                    <div x-data="{ openLogoutModal: false }">

                        {{-- 1. Tombol Pemicu (Yang diklik user di sidebar/navbar) --}}
                        <button type="button"
                                @click="openLogoutModal = true"
                                class="flex items-center gap-3 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition font-medium text-sm rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-red-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>

                        {{-- 2. Tampilan Pop-up Modal Konfirmasi --}}
                        <div x-show="openLogoutModal"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                            style="display: none;">

                            {{-- Box Modal --}}
                            <div @click.away="openLogoutModal = false"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-xl space-y-4">

                                {{-- Icon & Judul --}}
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Konfirmasi Keluar</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Yakin ingin keluar dari akun ChoiATK?</p>
                                    </div>
                                </div>

                                {{-- Tombol Aksi Pilihan --}}
                                <div class="grid grid-cols-2 gap-3 pt-2">
                                    {{-- Tombol Batal --}}
                                    <button type="button"
                                            @click="openLogoutModal = false"
                                            class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                        Kembali
                                    </button>

                                    {{-- Form Asli Logout Laravel (Eksekusi hanya jika klik tombol merah ini) --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full h-10 text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition rounded-xl shadow-md shadow-red-500/10">
                                            Ya, Keluar
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
