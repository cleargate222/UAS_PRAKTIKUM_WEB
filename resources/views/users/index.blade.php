<x-default-layout>
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded transition cursor-pointer">
                + Tambah User Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold uppercase">
                        <th class="p-4">Nama</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role / Hak Akses</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr>
                        <td class="p-4 font-medium">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $user->role == 'super_admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user->role == 'staff' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $user->role == 'auditor' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $user->role == 'supplier' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="p-4 flex justify-center space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Edit</a>

                            @if($user->id != Auth::id()) {{-- Agar tidak menghapus diri sendiri --}}
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold cursor-pointer">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-default-layout>
