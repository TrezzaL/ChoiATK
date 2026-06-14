<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar � ChoiATK | Premium Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
        }
        /* Custom scrollbar for a more premium feel */
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
{{-- Mengatur state Alpine global untuk modal, tipe password, dan logika kekuatan password --}}
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white"
      x-data="{
          termsModal: false,
          showPass: false,
          showConfirmPass: false,
          password: '',
          get strength() {
              if (this.password.length === 0) return { score: 0, label: '', color: 'bg-slate-200', text: 'text-slate-400' };
              let points = 0;
              if (this.password.length >= 8) points++;
              if (/[A-Z]/.test(this.password)) points++;
              if (/[0-9]/.test(this.password)) points++;
              if (/[^A-Za-z0-9]/.test(this.password)) points++;

              if (points <= 1) return { score: 1, label: 'Lemah ?', color: 'bg-red-500', width: 'w-1/4', text: 'text-red-500' };
              if (points === 2) return { score: 2, label: 'Sedang ??', color: 'bg-amber-500', width: 'w-2/4', text: 'text-amber-500' };
              if (points >= 3) return { score: 3, label: 'Kuat  Istimewa ??', color: 'bg-emerald-500', width: 'w-full', text: 'text-emerald-500' };
          }
      }">
    <div class="flex min-h-screen">
        <!-- Form Section -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 relative">
            <!-- Decorative blur blob -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            </div>

            <div class="w-full max-w-md mx-auto mt-20 lg:mt-0">
                <!-- Logo Area -->
                <div class="mb-5">
                    <a href="/" class="block group">
                        <img src="{{ asset('images/logo.png') }}" alt="ChoiATK Logo" class="h-10 sm:h-12 w-auto group-hover:scale-105 transition-transform duration-300">
                    </a>
                </div>
                <div class="mb-10 text-center lg:text-left">
                    <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Buat Akun Baru</h1>
                    <p class="text-slate-500">Bergabunglah bersama kami dan nikmati kemudahan berbelanja ATK berkualitas.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 @error('phone') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        @error('phone')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="contoh@email.com">
                        </div>
                        @error('email')<p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password Group -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                {{-- Menggunakan :type untuk toggle dan x-model untuk tracking kekuatan --}}
                                <input :type="showPass ? 'text' : 'password'"
                                       name="password"
                                       x-model="password"
                                       required
                                       class="w-full pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 password-input"
                                       placeholder="Masukkan password">

                                {{-- Tombol Toggle Mata --}}
                                <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>

                            {{-- Bar Indikator Kelemahan Password --}}
                            <div class="mt-2" x-show="password.length > 0" x-transition>
                                <div class="flex items-center justify-between text-[11px] font-semibold mb-1.5">
                                    <span class="text-slate-400">Keamanan:</span>
                                    <span :class="strength.text" x-text="strength.label"></span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden mb-3">
                                    <div class="h-full transition-all duration-300" :class="strength.color + ' ' + strength.width"></div>
                                </div>
                            </div>

                            {{-- Daftar Syarat Password (Interaktif) --}}
                            <div class="mt-2.5 space-y-1.5">
                                <p class="text-[11px] font-semibold text-slate-500 mb-1">Password yang kuat harus memuat:</p>

                                <div class="flex items-center gap-2 text-[11px]" :class="password.length >= 8 ? 'text-emerald-600 font-medium' : 'text-slate-400'">
                                    <svg x-show="password.length >= 8" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <svg x-show="password.length < 8" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /></svg>
                                    <span>Minimal 8 karakter</span>
                                </div>

                                <div class="flex items-center gap-2 text-[11px]" :class="/[A-Z]/.test(password) && /[a-z]/.test(password) ? 'text-emerald-600 font-medium' : 'text-slate-400'">
                                    <svg x-show="/[A-Z]/.test(password) && /[a-z]/.test(password)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <svg x-show="!(/[A-Z]/.test(password) && /[a-z]/.test(password))" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /></svg>
                                    <span>Huruf kapital & kecil (A-z)</span>
                                </div>

                                <div class="flex items-center gap-2 text-[11px]" :class="/[0-9]/.test(password) ? 'text-emerald-600 font-medium' : 'text-slate-400'">
                                    <svg x-show="/[0-9]/.test(password)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <svg x-show="!/[0-9]/.test(password)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /></svg>
                                    <span>Memuat angka (0-9)</span>
                                </div>

                                <div class="flex items-center gap-2 text-[11px]" :class="/[^A-Za-z0-9]/.test(password) ? 'text-emerald-600 font-medium' : 'text-slate-400'">
                                    <svg x-show="/[^A-Za-z0-9]/.test(password)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <svg x-show="!/[^A-Za-z0-9]/.test(password)" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9" /></svg>
                                    <span>Karakter unik (@, #, $, dll)</span>
                                </div>
                            </div>

                            @error('password')<p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>@enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <input :type="showConfirmPass ? 'text' : 'password'"
                                       name="password_confirmation"
                                       required
                                       class="w-full pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-xl text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-200 password-input"
                                       placeholder="Masukkan password">

                                {{-- Tombol Toggle Mata Konfirmasi --}}
                                <button type="button" @click="showConfirmPass = !showConfirmPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <svg x-show="!showConfirmPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showConfirmPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center mt-4">
                        <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-white cursor-pointer">
                        <label for="terms" class="ml-2 block text-sm text-slate-600 cursor-pointer">
                            Saya setuju dengan <button type="button" @click="termsModal = true" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline focus:outline-none">Syarat & Ketentuan</button>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-slate-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline transition-colors">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Section (Right Side) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">
            <img src="https://img.freepik.com/foto-gratis/tampilan-atas-alat-tulis-kantor-di-atas-laptop-di-atas-latar-belakang-putih_23-2148042099.jpg?semt=ais_hybrid&w=740&q=80" alt="Premium Stationery" class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end p-12 lg:p-20 h-full w-full">
                <div class="max-w-xl">
                    <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white text-xs font-semibold tracking-wider uppercase mb-6">Pilihan Profesional</span>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">Lengkapi Kebutuhan <span class="text-indigo-400">Alat Tulis</span> Anda</h2>
                    <p class="text-lg text-slate-300 mb-10 leading-relaxed">Kami menyediakan produk ATK berkualitas tinggi untuk mendukung produktivitas dan kreativitas tanpa batas. Temukan pengalaman berbelanja yang berbeda.</p>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-5 rounded-2xl border border-white/10">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://i.pravatar.cc/100?img=1" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://i.pravatar.cc/100?img=2" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-800" src="https://i.pravatar.cc/100?img=3" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-indigo-600 flex items-center justify-center text-xs font-bold text-white">+2k</div>
                        </div>
                        <div class="text-sm text-white">
                            <p class="font-semibold">Dipercaya oleh ribuan</p>
                            <p class="text-slate-400">pelanggan di seluruh Indonesia.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute top-1/4 right-0 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-1/4 left-1/4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>
    </div>

    {{-- KELOMPOK MODAL POP-UP --}}
    <template x-teleport="body">
    <div x-show="termsModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="termsModal = false">
        <div x-show="termsModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="termsModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="termsModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="relative w-full max-w-lg bg-white p-6 rounded-2xl border border-slate-100 shadow-2xl text-left transition-all">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Syarat & Ketentuan ChoiATK</h3>
                    <button type="button" @click="termsModal = false" class="text-slate-400 hover:text-slate-600 p-1.5 hover:bg-slate-50 rounded-xl transition">?</button>
                </div>
                <div class="max-h-72 overflow-y-auto text-sm text-slate-600 space-y-3 pr-1 leading-relaxed">
                    <p class="font-semibold text-slate-800">1. Ketentuan Umum</p>
                    <p>Dengan mendaftar di ChoiATK, Anda menyatakan bahwa data yang dimasukkan (Nama, No. HP, Email) adalah data asli dan valid untuk keperluan konfirmasi pesanan.</p>
                    <p class="font-semibold text-slate-800">2. Pemesanan & Pembayaran</p>
                    <p>Setiap orderan masuk harus melewati proses verifikasi oleh Admin. Untuk metode bayar tunai (CASH), transaksi dianggap selesai jika pembayaran dilakukan langsung di kasir toko resmi kami.</p>
                    <p class="font-semibold text-slate-800">3. Keamanan Akun</p>
                    <p>Anda bertanggung jawab penuh menjaga kerahasiaan password akun Anda. Pihak ChoiATK tidak bertanggung jawab atas kerugian yang diakibatkan kelalaian pengguna.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                    <button type="button" @click="termsModal = false" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-md shadow-indigo-500/10">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </template>
</body>
</html>
