<x-default-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Pengguna</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data pengguna dan hak akses sistem.</p>
            </div>
            <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah User
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-5">Nama & Email</th>
                            <th class="p-5">Hak Akses (Role)</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-5">
                                <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                <p class="text-gray-500 text-xs mt-0.5">{{ $user->email }}</p>
                            </td>
                            <td class="p-5">
                                <span class="px-3 py-1 rounded-full text-xs font-bold border
                                    {{ $user->role == 'super_admin' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                    {{ $user->role == 'admin' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                    {{ $user->role == 'staff' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                    {{ $user->role == 'auditor' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                    {{ $user->role == 'supplier' ? 'bg-gray-100 text-gray-700 border-gray-200' : '' }}">
                                    {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="p-5 flex justify-center items-center gap-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm transition-colors">Edit</a>

                                @if($user->id != Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold text-sm transition-colors cursor-pointer">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-default-layout>
