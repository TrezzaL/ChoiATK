{{-- Premium Dark Sidebar — Mobile Drawer + Desktop Fixed --}}
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
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
         style="display:none;"></div>

    {{-- Sidebar Panel --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white flex flex-col justify-between shadow-2xl z-50 shrink-0 transition-transform duration-300 ease-in-out
                  lg:translate-x-0 lg:static lg:inset-auto lg:shadow-sm"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- TOP: Logo + Brand --}}
        <div>
            <div class="px-6 py-6 border-b border-slate-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/40 group-hover:scale-105 transition-transform shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                        </svg>
                    </div>
                    <div>
                        <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-7 w-auto">
                        <span class="text-[10px] text-slate-500 font-medium tracking-wider uppercase pl-1">Admin Panel</span>
                    </div>
                </a>
                {{-- Close button (mobile only) --}}
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white transition p-1 rounded-lg hover:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation Menu --}}
            <nav class="px-3 py-5 space-y-0.5">
                <p class="px-3 text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-3">Menu Utama</p>

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>

                {{-- Kategori --}}
                <a href="{{ route('admin.category.index') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.category.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.category.*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>Kategori</span>
                    @if(request()->routeIs('admin.category.*'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>

                {{-- Produk --}}
                <a href="{{ route('admin.product.index') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.product.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.product.*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Daftar Produk</span>
                    @if(request()->routeIs('admin.product.*'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>

                {{-- Order --}}
                <a href="{{ route('admin.order.index') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.order*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.order*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Manajemen Order</span>
                    @if(request()->routeIs('admin.order*'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>

                {{-- Hutang --}}
                <a href="{{ route('admin.hutang.index') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.hutang.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.hutang.*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Buku Hutang</span>
                    @if(request()->routeIs('admin.hutang.*'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>

                {{-- Laporan --}}
                <a href="{{ route('admin.laporan') }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group
                          {{ request()->routeIs('admin.laporan') ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.laporan') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Laporan</span>
                    @if(request()->routeIs('admin.laporan'))
                        <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
                    @endif
                </a>
            </nav>
        </div>

        {{-- BOTTOM: User Info + Logout --}}
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-slate-800 transition group cursor-default">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-sm border-2 border-blue-500 shadow shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <span class="text-sm font-semibold text-white truncate block">{{ auth()->user()->name }}</span>
                    <span class="text-[11px] text-blue-400 font-medium">Administrator</span>
                </div>
                <div x-data="{ openLogoutModal: false }" class="shrink-0">
                    <button type="button" @click="openLogoutModal = true" title="Logout"
                            class="text-slate-500 hover:text-red-400 transition p-1 rounded-lg hover:bg-slate-700">
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
