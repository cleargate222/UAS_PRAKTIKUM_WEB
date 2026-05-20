<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" class="p-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 rounded-xl transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Pengguna</h2>
                <p class="text-sm text-gray-500">Perbarui informasi dan hak akses untuk {{ $user->name }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Input group format -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-sm font-bold text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-50 border @error('name') border-rose-500 @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-transparent transition-all" required>
                    @error('name') <p class="text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-bold text-gray-700">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-50 border @error('email') border-rose-500 @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-transparent transition-all" required>
                    @error('email') <p class="text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="role" class="block text-sm font-bold text-gray-700">Hak Akses (Role)</label>
                    <select id="role" name="role" class="w-full bg-gray-50 border @error('role') border-rose-500 @else border-gray-200 @enderror rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-transparent transition-all" required>
                        <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="auditor" {{ old('role', $user->role) == 'auditor' ? 'selected' : '' }}>Auditor</option>
                        <option value="supplier" {{ old('role', $user->role) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                    </select>
                    @error('role') <p class="text-xs text-rose-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('users.index') }}" class="text-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-sm hover:shadow-md transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
