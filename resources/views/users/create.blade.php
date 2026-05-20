<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header Controls -->
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Pengguna Baru</h2>
                <p class="text-sm text-slate-500 mt-0.5">Dafrarkan akun baru dan tentukan hak aksesnya di dalam sistem.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 md:p-8">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full bg-slate-50/50 border @error('name') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                           placeholder="Masukkan nama lengkap petugas"
                           required>
                    @error('name')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full bg-slate-50/50 border @error('email') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                           placeholder="contoh@gudangai.com"
                           required>
                    @error('email')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hak Akses (Role) -->
                <div class="space-y-1.5">
                    <label for="role" class="block text-sm font-bold text-slate-700">Pilih Hak Akses (Role)</label>
                    <select id="role"
                            name="role"
                            class="w-full bg-slate-50/50 border @error('role') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                            required>
                        <option value="" disabled selected>-- Pilih Peran Akun --</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff (Input Transaksi)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Kelola Stok)</option>
                        <option value="auditor" {{ old('role') == 'auditor' ? 'selected' : '' }}>Auditor (Cek Laporan)</option>
                        <option value="supplier" {{ old('role') == 'supplier' ? 'selected' : '' }}>Supplier (Distributor Barang)</option>
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin (Akses Penuh)</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="w-full bg-slate-50/50 border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                               placeholder="Minimal 8 karakter"
                               required>
                        @error('password')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700">Konfirmasi Password</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                               placeholder="Ulangi password"
                               required>
                    </div>
                </div>

                <!-- Form Footer Buttons -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('users.index') }}"
                       class="text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-xs hover:shadow-md transition-all cursor-pointer">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
