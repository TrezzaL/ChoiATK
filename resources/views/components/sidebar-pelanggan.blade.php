{{-- Pelanggan Sidebar — Desktop: static flex item | Mobile: drawer overlay --}}
<div x-data="{ sidebarOpen: false }"
     x-on:open-sidebar.window="sidebarOpen = true"
     x-on:close-sidebar.window="sidebarOpen = false"
     @keydown.escape.window="sidebarOpen = false">

    {{-- ═══════════════════════════════════════════════
         DESKTOP SIDEBAR — Always visible, static in flex layout
         Hidden on mobile (lg:block)
    ══════════════════════════════════════════════════ --}}
    <aside class="hidden lg:flex flex-col w-64 h-full bg-white border-r border-slate-100 shrink-0 shadow-sm overflow-y-auto">
        @include('components.sidebar-pelanggan-content')
    </aside>

    {{-- ═══════════════════════════════════════════════
         MOBILE DRAWER — Overlay on top of content
         Only visible on mobile (lg:hidden)
    ══════════════════════════════════════════════════ --}}
    <div class="lg:hidden">
        {{-- Backdrop --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40"
             style="display:none;"></div>

        {{-- Drawer Panel --}}
        <aside x-show="sidebarOpen"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 w-64 flex flex-col bg-white border-r border-slate-100 shadow-xl z-50"
               style="display:none;">
            @include('components.sidebar-pelanggan-content')
        </aside>
    </div>
</div>
