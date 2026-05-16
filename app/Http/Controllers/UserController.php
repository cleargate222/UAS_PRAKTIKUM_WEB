<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->get('role'));
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->paginate(15);

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => ['super_admin', 'admin', 'staff', 'auditor', 'supplier'],
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,staff,auditor,supplier',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
                       ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => ['super_admin', 'admin', 'staff', 'auditor', 'supplier'],
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,staff,auditor,supplier',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.show', $user)
                       ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->back()
                           ->withErrors(['message' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();

        return redirect()->route('users.index')
                       ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Get users by role (API).
     */
    public function byRole(Request $request)
    {
        $role = $request->get('role');

        $users = User::where('role', $role)->get(['id', 'name', 'email', 'role']);

        return response()->json($users);
    }
}
