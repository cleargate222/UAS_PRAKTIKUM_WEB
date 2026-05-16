<x-default-layout>
    <div class="max-w-xl bg-white p-6 rounded-lg shadow mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pengguna Baru</h1>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                <input type="email" name="email" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Pilih Role</label>
                <select name="role" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                    <option value="staff">Staff (Input Transaksi)</option>
                    <option value="admin">Admin (Kelola Stok)</option>
                    <option value="auditor">Auditor (Cek Laporan)</option>
                    <option value="supplier">Supplier (Distributor Barang)</option>
                    <option value="super_admin">Super Admin (Akses Penuh)</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <a href="{{ route('users.index') }}" class="text-gray-500 py-2 px-4">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded font-bold hover:bg-indigo-700 cursor-pointer transition">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</x-default-layout>
