<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login'); // Pastikan Dika sudah buat file ini
    }

    // Memproses data login
    public function login(Request $request)
    {
        // 1. Validasi input dari user
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah email & password cocok dengan database
        if (Auth::attempt($credentials)) {
            // Jika COCOK, buat session baru
            $request->session()->regenerate();

            // 3. Mencatat Buku Tamu (Login History)
            LoginHistory::create([
                'user_id' => Auth::id(),      // ID siapa yang login
                'ip_address' => $request->ip(), // Alamat IP perangkat
                'login_at' => now(),           // Jam saat ini
            ]);

            // Arahkan ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika GAGAL, kembalikan ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
