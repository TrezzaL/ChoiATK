{{-- Premium Pelanggan Sidebar — Mobile Drawer + Desktop Fixed --}}
<div x-data="{ sidebarOpen: false }"
     x-on:open-sidebar.window="sidebarOpen = true"
     x-on:close-sidebar.window="sidebarOpen = false"
     @keydown.escape.window="sidebarOpen = false">

    {{-- Mobile Overlay Backdrop --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"
         style="display:none;"></div>

    {{-- Sidebar Panel --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-100 flex flex-col justify-between shadow-xl z-50 shrink-0 transition-transform duration-300 ease-in-out
                  lg:translate-x-0 lg:static lg:inset-auto lg:shadow-sm"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- TOP: Logo --}}
        <div>
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                        </svg>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-7 w-auto">
                        <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">Portal Pelanggan</span>
                    </div>
                </a>
                {{-- Close button (mobile only) --}}
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-700 transition p-1 rounded-lg hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="px-3 py-5">
                {{-- Group: Menu Utama --}}
                <div class="mb-6">
                    <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Menu Utama</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('pelanggan.dashboard') }}" @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                                  {{ request()->routeIs('pelanggan.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                 class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('pelanggan.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                            @if(request()->routeIs('pelanggan.dashboard'))
                                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100 mb-6"></div>

                {{-- Group: Belanja --}}
                <div>
                    <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Belanja</p>
                    <div class="space-y-0.5">

                        {{-- Katalog --}}
                        <a href="{{ route('pelanggan.katalog') }}" @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                                  {{ request()->routeIs('pelanggan.katalog') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                 class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('pelanggan.katalog') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                            </svg>
                            <span>Katalog ATK</span>
                            @if(request()->routeIs('pelanggan.katalog'))
                                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                            @endif
                        </a>

                        {{-- Keranjang --}}
                        <a href="{{ route('pelanggan.cart.index') }}" @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                                  {{ request()->routeIs('pelanggan.cart.index') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                 class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('pelanggan.cart.index') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <span>Keranjang Saya</span>
                            @if(request()->routeIs('pelanggan.cart.index'))
                                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                            @endif
                        </a>

                        {{-- Pesanan --}}
                        <a href="{{ route('pelanggan.order.index') }}" @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                                  {{ request()->routeIs('pelanggan.order.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                                 class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('pelanggan.order.*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Pesanan Saya</span>
                            @if(request()->routeIs('pelanggan.order.*'))
                                <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                            @endif
                        </a>

                    </div>
                </div>
            </nav>
        </div>

        {{-- BOTTOM: User + Logout --}}
        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-slate-50 transition group cursor-default">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-sm text-white shadow shadow-blue-500/20 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <span class="text-sm font-semibold text-slate-800 truncate block">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-blue-500 font-medium">Pelanggan</span>
                </div>
                <div x-data="{ openLogoutModal: false }" class="shrink-0">
                    <button type="button" @click="openLogoutModal = true" title="Logout"
                            class="text-slate-400 hover:text-red-500 transition p-1 rounded-lg hover:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                    <div x-show="openLogoutModal"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                        style="display: none;">
                        <div @click.away="openLogoutModal = false"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            class="bg-white rounded-2xl border border-slate-100 max-w-sm w-full p-6 shadow-xl space-y-4 text-left">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Konfirmasi Keluar</h3>
                                    <p class="text-xs text-slate-400 mt-0.5">Yakin ingin keluar dari akun ChoiATK?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <button type="button" @click="openLogoutModal = false" class="h-10 text-xs font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 transition rounded-xl">Batal</button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full h-10 text-xs font-bold text-white bg-red-600 hover:bg-red-700 transition rounded-xl shadow-md shadow-red-500/10">Ya, Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
