<x-default-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Mutasi Stok Bulanan</h1>
            <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded transition cursor-pointer">
                🖨️ Cetak Laporan
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow border-t-4 border-gray-500">
                <span class="text-xs text-gray-400 font-bold uppercase">Total Unit Stok</span>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalStok }} Unit</p>
            </div>
            <div class="bg-white p-4 rounded shadow border-t-4 border-green-500">
                <span class="text-xs text-gray-400 font-bold uppercase">Total Barang Masuk</span>
                <p class="text-2xl font-bold text-green-600 mt-1">+ {{ $transactionsIn }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow border-t-4 border-red-500">
                <span class="text-xs text-gray-400 font-bold uppercase">Total Barang Keluar</span>
                <p class="text-2xl font-bold text-red-600 mt-1">- {{ $transactionsOut }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
            <div class="p-4 border-b font-bold text-gray-700">Mutasi Stok Terakhir</div>
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 font-semibold">
                        <th class="p-3">Produk</th>
                        <th class="p-3">Tipe</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($recentTransactions as $tx)
                    <tr>
                        <td class="p-3 font-medium">{{ $tx->product->name }}</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $tx->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tx->type == 'in' ? 'Masuk' : 'Keluar' }}
                            </span>
                        </td>
                        <td class="p-3 font-semibold">{{ $tx->quantity }}</td>
                        <td class="p-3 text-gray-600">{{ $tx->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>
