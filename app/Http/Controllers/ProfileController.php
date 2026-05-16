<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan form untuk mengedit profil user yang sedang login
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Mengupdate profil user yang sedang login
    public function update(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Jika password diisi, hash password terlebih dahulu
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Update data profil user
        $user->update($validated);

        // Catat aktivitas ke audit log
        AuditHelper::logUpdateProfile($user->name);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }
}
