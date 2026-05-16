<x-default-layout>
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Keamanan Akun</h1>
        <p class="text-sm text-gray-500 mb-6">Perbarui informasi profil Anda dan amankan akun dengan password yang kuat.</p>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400">Alamat Email (Tidak dapat diubah)</label>
                <input type="email" value="{{ $user->email }}" class="w-full mt-1 p-2 border bg-gray-50 text-gray-400 rounded cursor-not-allowed" disabled>
                <p class="text-xs text-gray-400 mt-1">Hubungi Super Admin jika ingin mengubah email.</p>
            </div>

            <hr class="border-gray-100 my-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-default-layout>
