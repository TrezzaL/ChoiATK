<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPelanggan
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role 'pelanggan'
        if (auth()->check() && auth()->user()->role === 'pelanggan') {
            return $next($request); // Lanjutkan ke request berikutnya (controller)
        }

        // Jika bukan pelanggan, redirect ke halaman utama dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
