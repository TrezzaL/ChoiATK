<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — ChoiATK | Premium Access</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">
    <div class="flex min-h-screen">
        <!-- Form Section -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative">
            <!-- Decorative blur blob -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            </div>

            <div class="w-full max-w-md mx-auto mt-20 lg:mt-0">
                <!-- Logo Area (Top Right) -->
                <div class="mb-5">
                    <a href="/" class="block group">
                        <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-10 sm:h-12 w-auto group-hover:scale-105 transition-transform duration-300">
                    </a>
                </div>
                <div class="mb-10 text-center lg:text-left">
                    <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Selamat Datang Kembali</h1>
                    <p class="text-slate-500">Masuk ke akun Anda untuk melanjutkan belanja alat tulis.</p>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-600 text-sm font-medium rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400
                                focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200
                                @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="contoh@email.com">
                        </div>
                        @error('email')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPass: false }">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 hover:underline transition-colors">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            {{-- Icon Kunci di Sisi Kiri --}}
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>

                            {{-- Input Password dinamis menggunakan :type berbasis state Alpine --}}
                            <input :type="showPass ? 'text' : 'password'"
                                name="password"
                                required
                                class="w-full pl-11 pr-11 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400
                                focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200
                                @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="••••••••">

                            {{-- Tombol Ikon Mata di Sisi Kanan Input --}}
                            <button type="button"
                                    @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                {{-- Ikon Mata Terbuka (Muncul saat password disembunyikan) --}}
                                <svg x-show="!showPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{-- Ikon Mata Tercoret (Muncul saat password ditampilkan) --}}
                                <svg x-show="showPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-white cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
                            Masuk
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-slate-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline transition-colors">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Section (Right Side) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
            <!-- Background Image (Different from register for variation) -->
            <img src="https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?q=80&w=2070&auto=format&fit=crop"
                alt="Workspace" class="absolute inset-0 w-full h-full object-cover opacity-60">

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>

            <!-- Content over image -->
            <div class="relative z-10 flex flex-col justify-end p-12 lg:p-20 h-full w-full">
                <div class="max-w-xl">
                    <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white text-xs font-semibold tracking-wider uppercase mb-6">
                        Akses Prioritas
                    </span>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                        Kembali Mengukir <span class="text-indigo-400">Karya</span>
                    </h2>
                    <p class="text-lg text-slate-300 mb-10 leading-relaxed">
                        Lanjutkan pencarian alat tulis kantor terbaik Anda dan rasakan kemudahan transaksi dengan sistem keamanan yang terjamin.
                    </p>

                    <!-- Stats Badge -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                            <p class="text-3xl font-bold text-white mb-1">10k+</p>
                            <p class="text-sm text-slate-300">Produk Tersedia</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                            <p class="text-3xl font-bold text-white mb-1">99%</p>
                            <p class="text-sm text-slate-300">Kepuasan Pelanggan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-1/4 right-0 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-1/4 left-1/4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>
    </div>
</body>
</html>
