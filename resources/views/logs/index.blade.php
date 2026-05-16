<x-default-layout>
    <div class="space-y-8">
        <h1 class="text-2xl font-bold text-gray-800">System Audit Logs</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-50 p-4 border-b">
                <h2 class="font-bold text-gray-700">Aktivitas Operasional Sistem</h2>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs font-semibold uppercase">
                        <th class="p-3">Waktu</th>
                        <th class="p-3">Aktor (User)</th>
                        <th class="p-3">Tindakan / Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y">
                    @foreach($activityLogs as $log)
                    <tr>
                        <td class="p-3 text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td class="p-3 font-semibold">{{ $log->user->name }}</td>
                        <td class="p-3 text-blue-600">{{ $log->activity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-3">{{ $activityLogs->links() }}</div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-gray-50 p-4 border-b">
                <h2 class="font-bold text-gray-700">Riwayat Autentikasi</h2>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs font-semibold uppercase">
                        <th class="p-3">Waktu Masuk</th>
                        <th class="p-3">Nama User</th>
                        <th class="p-3">Alamat IP</th>
                        <th class="p-3">Perangkat / Browser</th> </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y">
                    @foreach($loginHistories as $history)
                    <tr>
                        <td class="p-3 text-gray-500">{{ \Carbon\Carbon::parse($history->login_at)->format('d M Y H:i') }} WAI</td>
                        <td class="p-3 font-semibold">{{ $history->user->name }}</td>
                        <td class="p-3 font-mono text-xs bg-gray-50">{{ $history->ip_address }}</td>
                        <td class="p-3 text-xs text-gray-600 max-w-xs truncate" title="{{ $history->user_agent }}">
                            {{ $history->user_agent }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-3">{{ $loginHistories->links() }}</div>
        </div>
    </div>
</x-default-layout>
