<x-default-layout>
    <div class="space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan inventori dan aktivitas sistem saat ini.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <h3 class="text-gray-500 text-xs font-bold tracking-wider uppercase mb-2 relative z-10">Total Jenis Produk</h3>
                <p class="text-4xl font-black text-gray-800 relative z-10">{{ $totalProducts }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                <h3 class="text-gray-500 text-xs font-bold tracking-wider uppercase mb-2 relative z-10">Stok Kritis (Butuh Restock)</h3>
                <p class="text-4xl font-black text-red-500 relative z-10">{{ $stokKritis }}</p>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Aktivitas Terkini</h2>

                @if(Auth::user()->role == 'supplier')
                    <p class="text-sm text-gray-500 mt-1">Menampilkan daftar produk supply Anda saat ini.</p>
                @elseif(Auth::user()->role == 'auditor')
                    <p class="text-sm text-gray-500 mt-1">5 Transaksi Terakhir Sistem:</p>
                @else
                    <p class="text-sm text-gray-500 mt-1">Produk yang baru ditambahkan:</p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            @if(Auth::user()->role == 'supplier')
                                <th class="p-4">Nama Barang Anda</th>
                                <th class="p-4">Stok Gudang</th>
                            @elseif(Auth::user()->role == 'auditor')
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Nama Barang</th>
                                <th class="p-4">Jenis</th>
                                <th class="p-4">Jumlah</th>
                            @else
                                <th class="p-4">Nama Barang</th>
                                <th class="p-4">Stok</th>
                                <th class="p-4">Tanggal Masuk</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(Auth::user()->role == 'supplier')
                            @forelse($myProducts as $prod)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-semibold text-gray-900">{{ $prod->name }}</td>
                                <td class="p-4 text-gray-600"><span class="bg-gray-100 px-3 py-1 rounded-full">{{ $prod->stock }} unit</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="p-6 text-center text-gray-400 italic">Anda belum memasok produk apapun.</td></tr>
                            @endforelse
                        @elseif(Auth::user()->role == 'auditor')
                            @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-gray-500 font-mono text-xs">{{ $tx->created_at->format('d M Y H:i') }}</td>
                                <td class="p-4 font-semibold text-gray-900">{{ $tx->product->name }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $tx->type == 'in' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $tx->type == 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="p-4 font-mono font-bold {{ $tx->type == 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->type == 'in' ? '+' : '-' }}{{ $tx->quantity }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-6 text-center text-gray-400 italic">Belum ada rekaman transaksi.</td></tr>
                            @endforelse
                        @else
                            @forelse($latestProducts as $prod)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-semibold text-gray-900">{{ $prod->name }}</td>
                                <td class="p-4 text-gray-600"><span class="bg-gray-100 px-3 py-1 rounded-full">{{ $prod->stock }} unit</span></td>
                                <td class="p-4 text-gray-400 font-mono text-xs">{{ $prod->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="p-6 text-center text-gray-400 italic">Belum ada produk yang ditambahkan.</td></tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- AI Analytics Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 p-8 rounded-2xl shadow-lg text-white">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl font-bold flex items-center gap-2">
                        <span>✨</span> InventoryAgent AI Analytics
                    </h2>
                    <p class="text-indigo-200 mt-2 text-sm max-w-xl leading-relaxed">
                        Manfaatkan kecerdasan buatan untuk menganalisis pola transaksi bulanan Anda dan dapatkan prediksi pengadaan stok pintar.
                    </p>
                </div>
                <form action="{{ url()->current() }}" method="GET">
                    <input type="hidden" name="analyze" value="1">
                    <button type="submit" class="bg-white text-indigo-900 hover:bg-indigo-50 font-bold px-6 py-3 rounded-xl shadow-md transition-transform hover:-translate-y-0.5 cursor-pointer whitespace-nowrap">
                        Mulai Analisis AI
                    </button>
                </form>
            </div>

            @if(isset($analysis) && $analysis)
                <div class="mt-6 p-6 bg-white/10 backdrop-blur-sm text-indigo-50 rounded-xl border border-white/20 text-sm leading-relaxed prose prose-invert max-w-none shadow-inner">
                    {!! Str::markdown($analysis) !!}
                </div>
            @endif
        </div>
    </div>
</x-default-layout>
