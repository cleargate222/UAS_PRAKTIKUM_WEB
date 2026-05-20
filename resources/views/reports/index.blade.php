<x-default-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan Mutasi Bulanan</h1>
                <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas inventaris untuk periode berjalan.</p>
            </div>
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-xs transition-all cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Total Stok -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-slate-100 rounded-lg text-slate-600">📦</div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Stok</span>
                </div>
                <p class="text-3xl font-black text-slate-900">{{ number_format($totalStok) }} <span class="text-sm font-medium text-slate-400">unit</span></p>
            </div>

            <!-- Barang Masuk -->
            <div class="bg-white p-6 rounded-2xl border border-emerald-100 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-emerald-50 rounded-lg text-emerald-600">📥</div>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Barang Masuk</span>
                </div>
                <p class="text-3xl font-black text-emerald-600">+ {{ number_format($transactionsIn) }}</p>
            </div>

            <!-- Barang Keluar -->
            <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-xs">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-rose-50 rounded-lg text-rose-600">📤</div>
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-widest">Barang Keluar</span>
                </div>
                <p class="text-3xl font-black text-rose-600">- {{ number_format($transactionsOut) }}</p>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/60 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="font-bold text-slate-800">Mutasi Stok Terakhir</h2>
                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Top 10 Terbaru</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/75 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Produk</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Kuantitas</th>
                            <th class="p-4">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentTransactions as $tx)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6 font-bold text-slate-800">{{ $tx->product->name ?? 'Produk Dihapus' }}</td>
                            <td class="p-4">
                                @if($tx->type == 'in')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">MASUK</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">KELUAR</span>
                                @endif
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-700">{{ $tx->quantity }}</td>
                            <td class="p-4 text-slate-600">{{ $tx->user->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 italic">Belum ada data mutasi bulan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-default-layout>
