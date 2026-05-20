<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header Controls -->
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() == route('profile.edit') ? route('dashboard') : url()->previous() }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Keamanan Akun</h2>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui informasi kredensial profil Anda dan amankan akun dengan kata sandi yang kuat.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 md:p-8">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full bg-slate-50/50 border @error('name') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                           required>
                    @error('name')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email (Protected) -->
                <div class="space-y-1.5 opacity-80">
                    <label class="block text-sm font-bold text-slate-400">Alamat Email <span class="text-xs font-normal italic">(Tidak dapat diubah)</span></label>
                    <div class="relative flex items-center">
                        <input type="email"
                               value="{{ $user->email }}"
                               class="w-full bg-slate-100 border border-slate-200 text-slate-400 font-medium rounded-xl px-4 py-3 text-sm cursor-not-allowed select-none"
                               disabled>
                        <span class="absolute right-4 text-sm select-none">🔒</span>
                    </div>
                    <p class="text-xs text-slate-400 font-medium mt-1">Hubungi manajemen tim <span class="text-indigo-600 font-semibold">Super Admin</span> jika bermaksud mengubah data email.</p>
                </div>

                <hr class="border-slate-100 my-6">

                <div class="bg-slate-50/60 rounded-xl p-4 border border-slate-100 mb-2">
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">💡 **Tips Sandi**: Kosongkan baris isian di bawah ini jika Anda **tidak berencana** untuk menukar kata sandi lama Anda saat ini.</p>
                </div>

                <!-- Password Baru Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-bold text-slate-700">Password Baru</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="w-full bg-slate-50/50 border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                               placeholder="Minimal 8 karakter baru">
                        @error('password')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700">Konfirmasi Password Baru</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                               placeholder="Ulangi sandi baru">
                    </div>
                </div>

                <!-- Form Footer Buttons -->
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('dashboard') }}"
                       class="text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-xs hover:shadow-md transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
