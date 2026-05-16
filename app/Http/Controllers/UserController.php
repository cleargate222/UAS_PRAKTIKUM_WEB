<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar semua user (hanya super_admin)
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan user baru ke database
    public function store(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,staff,auditor,supplier',
        ]);

        // Simpan user baru ke database dengan password yang di-hash
        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Catat aktivitas ke audit log
        AuditHelper::logCreateUser($newUser);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit user
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Mengupdate data user
    public function update(Request $request, string $id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:super_admin,admin,staff,auditor,supplier',
        ]);

        // Update data user
        $user->update($validated);

        // Catat aktivitas ke audit log
        AuditHelper::logUpdateUser($user);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // Menghapus user dari database
    public function destroy(string $id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Simpan data user sebelum dihapus
        $userName = $user->name;
        $userEmail = $user->email;

        // Hapus user dari database
        $user->delete();

        // Catat aktivitas ke audit log
        AuditHelper::logDeleteUser($userName, $userEmail);

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
