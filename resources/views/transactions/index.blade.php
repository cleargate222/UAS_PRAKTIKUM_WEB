<x-default-layout>
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
            <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded shadow font-semibold">
                + Input Transaksi Baru
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-600 font-bold uppercase tracking-wider">
                        <th class="p-4">Waktu</th>
                        <th class="p-4">Produk</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Qty</th>
                        <th class="p-4">Petugas</th>
                        <th class="p-4 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-100">
                    @foreach($transactions as $tx)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 text-gray-500">{{ $tx->created_at->format('d M Y H:i') }}</td>
                        <td class="p-4 font-semibold text-gray-900">{{ $tx->product->name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $tx->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tx->type == 'in' ? 'MASUK' : 'KELUAR' }}
                            </span>
                        </td>
                        <td class="p-4 font-mono font-bold">{{ $tx->quantity }}</td>
                        <td class="p-4 text-gray-600">{{ $tx->user->name }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('transactions.show', $tx->id) }}" class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-blue-600 hover:text-blue-800 font-bold text-xs px-2.5 py-1.5 rounded transition shadow-sm cursor-pointer">
                                👁️
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-default-layout>
