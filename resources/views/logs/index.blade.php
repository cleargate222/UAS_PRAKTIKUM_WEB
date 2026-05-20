<x-default-layout>
    <div class="space-y-8">
        <!-- Header Halaman -->
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Audit Logs</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pantau jejak audit operasional, perubahan data, serta log masuk akun untuk menjaga keamanan sistem.</p>
        </div>

        <!-- BLOK 1: Aktivitas Operasional Sistem -->
        <div class="space-y-3">
            <div class="flex items-center gap-2 px-1">
                <span class="text-xl">⚙️</span>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Aktivitas Operasional Sistem</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 pl-6 w-48">Waktu</th>
                                <th class="p-4 w-64">Aktor (User)</th>
                                <th class="p-4">Tindakan / Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-50">
                            @forelse($activityLogs as $log)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Waktu -->
                                <td class="p-4 pl-6 text-slate-500 font-mono text-xs">
                                    {{ $log->created_at ? $log->created_at->format('d M Y H:i') : '-' }}
                                </td>

                                <!-- Aktor -->
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 bg-slate-100 rounded-lg flex items-center justify-center text-xs font-bold text-slate-600 border border-slate-200/50">
                                            {{ strtoupper(substr($log->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-slate-800">{{ $log->user->name ?? 'User Terhapus' }}</span>
                                    </div>
                                </td>

                                <!-- Aktivitas -->
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                        {{ $log->activity }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400 italic">
                                    Belum ada rekaman aktivitas operasional sistem.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Berfungsi Aman -->
            @if(method_exists($activityLogs, 'links'))
                <div class="mt-2 px-2">
                    {{ $activityLogs->links() }}
                </div>
            @endif
        </div>

        <!-- BLOK 2: Riwayat Autentikasi -->
        <div class="space-y-3">
            <div class="flex items-center gap-2 px-1">
                <span class="text-xl">🛡️</span>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Riwayat Autentikasi</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 pl-6 w-48">Waktu Masuk</th>
                                <th class="p-4 w-64">Nama User</th>
                                <th class="p-4 w-44">Alamat IP</th>
                                <th class="p-4">Perangkat / Browser</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-50">
                            @foreach($loginHistories as $history)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <!-- Waktu Masuk -->
                                <td class="p-4 pl-6 text-slate-500 font-mono text-xs">
                                    {{ $history->login_at ? \Carbon\Carbon::parse($history->login_at)->format('d M Y H:i') : '-' }} WAI
                                </td>

                                <!-- Nama User -->
                                <td class="p-4 font-bold text-slate-800">
                                    {{ $history->user->name ?? 'User Terhapus' }}
                                </td>

                                <!-- Alamat IP -->
                                <td class="p-4">
                                    <span class="font-mono text-xs font-semibold px-2 py-1 bg-slate-100 border border-slate-200/60 rounded-md text-slate-600">
                                        {{ $history->ip_address ?? '0.0.0.0' }}
                                    </span>
                                </td>

                                <!-- Perangkat -->
                                <td class="p-4 text-xs text-slate-500 max-w-xs truncate font-medium" title="{{ $history->user_agent }}">
                                    {{ $history->user_agent }}
                                </td>
                            </tr>
                            @endforeach
                            @if($loginHistories->isEmpty())
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400 italic">
                                    Belum ada rekaman riwayat masuk (login).
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Berfungsi Aman -->
            @if(method_exists($loginHistories, 'links'))
                <div class="mt-2 px-2">
                    {{ $loginHistories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-default-layout>
