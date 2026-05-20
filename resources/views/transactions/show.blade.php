<x-default-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Header Controls -->
        <div class="flex justify-between items-center print:hidden">
            <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <button onclick="window.print()" class="bg-gray-900 hover:bg-black text-white text-sm font-bold px-5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Nota
            </button>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden print:shadow-none print:border-none">
            <!-- Receipt Header -->
            <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 p-8 text-white flex justify-between items-center">
                <div class="relative z-10">
                    <h1 class="text-2xl font-black tracking-widest uppercase">Nota Mutasi</h1>
                    <p class="text-sm text-gray-400 mt-1 font-mono">TRX-#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="relative z-10 text-right">
                    <span class="px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase border-2 {{ $transaction->type == 'in' ? 'border-emerald-400 text-emerald-400' : 'border-rose-400 text-rose-400' }}">
                        {{ $transaction->type == 'in' ? 'Barang Masuk' : 'Barang Keluar' }}
                    </span>
                </div>
            </div>

            <!-- Receipt Body -->
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100 pb-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Produk / Barang</label>
                        <p class="text-xl font-bold text-gray-900 mt-2">{{ $transaction->product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Mutasi</label>
                        <p class="text-2xl font-black font-mono mt-1 {{ $transaction->type == 'in' ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $transaction->type == 'in' ? '+' : '-' }}{{ $transaction->quantity }} <span class="text-lg text-gray-500 font-bold">Unit</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu Transaksi</label>
                        <p class="text-base font-semibold text-gray-800 mt-2">{{ $transaction->created_at->format('d F Y') }} <span class="text-gray-400 font-mono text-sm ml-1">{{ $transaction->created_at->format('H:i:s') }}</span></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Petugas Input</label>
                        <p class="text-base font-semibold text-gray-800 mt-2 flex items-center gap-2">
                            {{ $transaction->user->name }}
                            <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs font-bold">{{ ucfirst($transaction->user->role) }}</span>
                        </p>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="pt-6 border-t border-dashed border-gray-200">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Catatan Transaksi</label>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-700 font-medium">
                        @if($transaction->note)
                            <p class="italic">"{{ $transaction->note }}"</p>
                        @else
                            <p class="text-gray-400 italic">Tidak ada catatan yang dilampirkan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-5 text-center print:bg-transparent">
                <p class="text-xs text-gray-400 font-semibold tracking-wide">Sistem Inventori Berbasis Agen AI — Dicatat secara otomatis.</p>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body { background: white !important; }
            nav, aside, .print\:hidden, button { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; }
            .max-w-3xl { max-w: 100% !important; }
        }
    </style>
</x-default-layout>
