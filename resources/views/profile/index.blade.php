<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header Profil -->
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-0.5">Informasi kartu identitas akun Anda di dalam ekosistem Smart Inventory AI.</p>
        </div>

        <!-- Profile Card View -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
            <!-- Banner Dekoratif Atas -->
            <div class="h-32 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 relative"></div>

            <!-- Konten Utama Kartu -->
            <div class="px-6 pb-8 relative flex flex-col items-center sm:items-start sm:flex-row gap-5 -mt-12">
                <!-- Avatar Lingkaran Besar -->
                <div class="w-24 h-24 bg-white p-1.5 rounded-2xl shadow-md border border-slate-100 flex-shrink-0">
                    <div class="w-full h-full bg-slate-100 rounded-xl flex items-center justify-center text-3xl font-black text-indigo-600">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <!-- Detail Identitas Singkat -->
                <div class="flex-1 text-center sm:text-left pt-2 sm:pt-14 space-y-1.5">
                    <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                        <span class="text-sm font-medium text-slate-500">{{ $user->email }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                            🛡️ {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </div>
                </div>

                <!-- Tombol Navigasi ke Edit -->
                <div class="sm:pt-14 w-full sm:w-auto">
                    <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-xs hover:shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Keamanan
                    </a>
                </div>
            </div>

            <!-- Detail Metadata Grid -->
            <div class="border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 bg-slate-50/40 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 text-sm">
                <div class="p-5 space-y-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Terdaftar Pada</span>
                    <p class="font-semibold text-slate-700">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="p-5 space-y-1">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Terakhir Diperbarui</span>
                    <p class="font-semibold text-slate-700">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

    </div>
</x-default-layout>
