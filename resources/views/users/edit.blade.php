<x-default-layout>
    <div class="container mx-auto p-4 md:p-6 max-w-2xl">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('users.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition duration-200">
                ⬅️
            </a>
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Edit Pengguna</h2>
                <p class="text-xs md:text-sm text-gray-500">Perbarui informasi dan hak akses akun {{ $user->name }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 md:p-6">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-200"
                           required>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-200"
                           required>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Hak Akses (Role)</label>
                    <div class="relative">
                        <select id="role"
                                name="role"
                                class="w-full bg-gray-50 border @error('role') border-red-500 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-200 appearance-none"
                                required>
                            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="auditor" {{ old('role', $user->role) == 'auditor' ? 'selected' : '' }}>Auditor</option>
                            <option value="supplier" {{ old('role', $user->role) == 'supplier' ? 'selected' : '' }}>Supplier</option>
                        </select>
                    </div>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('users.index') }}"
                       class="w-full sm:w-auto text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm shadow-md shadow-indigo-200 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-default-layout>
