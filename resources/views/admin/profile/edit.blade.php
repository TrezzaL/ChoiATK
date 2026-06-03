<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun — ChoiATK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar-admin/>
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
            <x-navbar-admin/>

            <main class="p-6 md:p-8 animate-page-load">
                <div class="max-w-2xl mx-auto space-y-6">

                    {{-- Header --}}
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Pengaturan Akun</h2>
                        <p class="text-sm text-slate-500 mt-1">Perbarui informasi profil dan kata sandi akun administrator kamu.</p>
                    </div>

                    {{-- Avatar Preview --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-center gap-5">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-extrabold text-2xl shadow-lg shadow-blue-500/20 shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-lg">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                            <span class="inline-flex items-center gap-1 mt-1.5 text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Administrator
                            </span>
                        </div>
                    </div>

                    {{-- Form Update Profil --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm">Informasi Profil</h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-4">
                                @csrf @method('PATCH')

                                @if(session('status') === 'profile-updated')
                                    <div class="flex items-center gap-2 text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-3 rounded-xl text-sm font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        Profil berhasil diperbarui!
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('name') border-red-400 ring-2 ring-red-200 @enderror">
                                    @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('email') border-red-400 ring-2 ring-red-200 @enderror">
                                    @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Form Update Password --}}
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-amber-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-amber-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm">Ubah Kata Sandi</h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                                @csrf @method('PUT')

                                @if(session('status') === 'password-updated')
                                    <div class="flex items-center gap-2 text-emerald-700 bg-emerald-50 border border-emerald-100 px-4 py-3 rounded-xl text-sm font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        Kata sandi berhasil diubah!
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kata Sandi Saat Ini</label>
                                    <input type="password" name="current_password"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('current_password') border-red-400 ring-2 ring-red-200 @enderror">
                                    @error('current_password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Kata Sandi Baru</label>
                                    <input type="password" name="password"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition @error('password') border-red-400 ring-2 ring-red-200 @enderror">
                                    @error('password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition">
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-amber-500/20 transition">
                                        Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-red-50 flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-red-700 text-sm">Zona Berbahaya</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-4 leading-relaxed">
                                Jika akun dihapus, semua data terkait akan hilang permanen dan tidak dapat dipulihkan.
                            </p>
                            {{-- Container Utama Modal Hapus Akun Alpine.js --}}
                            <div x-data="{ openDeleteAccountModal: false }">

                                {{-- 1. Tombol Pemicu Utama (Di halaman Pengaturan Akun) --}}
                                <button type="button"
                                        @click="openDeleteAccountModal = true"
                                        class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-5 py-2.5 rounded-xl text-sm font-bold border border-red-200 hover:border-red-600 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Hapus Akun Saya
                                </button>

                                {{-- 2. Pop-up Modal Konfirmasi Hapus Permanen (Dilemparkan ke Body) --}}
                                <template x-teleport="body">
                                    <div x-show="openDeleteAccountModal"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
                                        style="display: none;">

                                        {{-- Kotak Putih Modal --}}
                                        <div @click.away="openDeleteAccountModal = false"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            class="bg-white rounded-3xl border border-red-100 max-w-sm w-full p-6 shadow-2xl space-y-5">

                                            {{-- Konten Informasi Bahaya Tinggi --}}
                                            <div class="flex flex-col items-center text-center gap-3">
                                                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center text-red-600 ring-4 ring-red-50 mb-1">
                                                    {{-- Ikon Peringatan (Warning) --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-extrabold text-slate-900">Hapus Akun Permanen?</h3>
                                                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                                        Semua data profil dan riwayat pesanan kamu di ChoiATK akan dihapus dan <span class="font-bold text-red-600">tidak dapat dikembalikan</span>.
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Tombol Pilihan Aksi --}}
                                            <div class="grid grid-cols-2 gap-3 pt-2">
                                                {{-- Tombol Batal --}}
                                                <button type="button"
                                                        @click="openDeleteAccountModal = false"
                                                        class="h-11 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition rounded-xl">
                                                    Batal
                                                </button>

                                                {{-- Form Native DELETE Laravel --}}
                                                <form method="POST" action="{{ route('profile.destroy') }}" class="m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full h-11 text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition rounded-xl shadow-md shadow-red-500/20">
                                                        Ya, Hapus Akun
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>
