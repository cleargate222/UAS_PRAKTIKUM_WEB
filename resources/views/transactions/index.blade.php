<x-default-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Transaksi</h1>
                <p class="text-sm text-slate-500 mt-0.5">Pantau semua rekaman mutasi barang masuk dan keluar dari gudang.</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Input Transaksi Baru
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Waktu</th>
                            <th class="p-4">Produk</th>
                            <th class="p-4">Jenis</th>
                            <th class="p-4">Qty</th>
                            <th class="p-4">Petugas</th>
                            <th class="p-4 text-center pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @foreach($transactions as $tx)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="p-4 pl-6">
                                <span class="text-slate-700 font-medium">{{ $tx->created_at->format('d M Y') }}</span>
                                <span class="text-slate-400 font-mono text-xs block mt-0.5">{{ $tx->created_at->format('H:i') }}</span>
                            </td>
                            <td class="p-4 font-bold text-slate-900">{{ $tx->product->name }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold border inline-block
                                    {{ $tx->type == 'in' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                    {{ $tx->type == 'in' ? 'MASUK' : 'KELUAR' }}
                                </span>
                            </td>
                            <td class="p-4 font-mono font-bold text-base {{ $tx->type == 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type == 'in' ? '+' : '-' }}{{ $tx->quantity }}
                            </td>
                            <td class="p-4 text-slate-600 font-medium">{{ $tx->user->name }}</td>
                            <td class="p-4 text-center pr-6">
                                <a href="{{ route('transactions.show', $tx->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 transition-colors shadow-xs cursor-pointer" title="Lihat Detail Nota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-default-layout>
