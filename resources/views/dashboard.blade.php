<x-default-layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Jenis Produk</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalProducts }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase">Stok Kritis (Butuh Restock)</h3>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $stokKritis }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terkini</h2>

            @if(Auth::user()->role == 'supplier')
                <p class="text-sm text-gray-600 mb-4">Menampilkan daftar produk supply Anda saat ini.</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 font-semibold border-b">
                                <th class="p-3">Nama Barang Anda</th>
                                <th class="p-3">Stok Gudang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($myProducts as $prod)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-3 font-medium text-gray-900">{{ $prod->name }}</td>
                                <td class="p-3 text-gray-600">{{ $prod->stock }} unit</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="p-3 text-center text-gray-400 italic">Anda belum memasok produk apapun ke gudang ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif(Auth::user()->role == 'auditor')
                <p class="text-sm text-gray-600 mb-4">5 Transaksi Terakhir Sistem:</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 font-semibold border-b">
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Nama Barang</th>
                                <th class="p-3">Jenis</th>
                                <th class="p-3">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-3 text-gray-500 font-mono text-xs">{{ $tx->created_at->format('d M Y H:i') }}</td>
                                <td class="p-3 font-medium text-gray-900">{{ $tx->product->name }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $tx->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $tx->type == 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="p-3 font-mono font-bold {{ $tx->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->type == 'in' ? '+' : '-' }}{{ $tx->quantity }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-400 italic">Belum ada rekaman transaksi di dalam sistem.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                <p class="text-sm text-gray-600 mb-4">Produk yang baru ditambahkan:</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 font-semibold border-b">
                                <th class="p-3">Nama Barang</th>
                                <th class="p-3">Stok</th>
                                <th class="p-3">Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($latestProducts as $prod)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-3 font-medium text-gray-900">{{ $prod->name }}</td>
                                <td class="p-3 text-gray-600">{{ $prod->stock }} unit</td>
                                <td class="p-3 text-gray-400 font-mono text-xs">{{ $prod->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-gray-400 italic">Belum ada produk yang ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-6 rounded-lg shadow-md text-white mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold">InventoryAgent AI Analytics</h2>
                    <p class="text-sm text-purple-100 mt-1">Dapatkan prediksi pengadaan stok pintar berdasarkan pola transaksi bulanan.</p>
                </div>

                <form action="{{ url()->current() }}" method="GET">
                    <input type="hidden" name="analyze" value="1">
                    <button type="submit" class="bg-white text-indigo-600 hover:bg-purple-50 font-bold px-4 py-2 rounded shadow transition cursor-pointer">
                        Mulai Analisis AI
                    </button>
                </form>
            </div>

            @if(isset($analysis) && $analysis)
                <div class="mt-4 p-4 bg-white text-gray-800 rounded shadow-inner max-w-none text-sm leading-relaxed prose prose-purple">
                    {!! Str::markdown($analysis) !!}
                </div>
            @endif
        </div>
    </div>
</x-default-layout>
