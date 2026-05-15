<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek: Apakah user sudah login? (Auth::check)
        // 2. Cek: Apakah role user saat ini ada dalam daftar yang diizinkan? (in_array)
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request); // Jika YA, silakan masuk ke halaman tujuan
        }

        // Jika TIDAK, tendang balik ke dashboard
        return redirect('/dashboard')->with('error', 'Akses Ditolak!');
    }
}
