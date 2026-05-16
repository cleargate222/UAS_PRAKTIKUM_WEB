<x-default-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex justify-between items-center print:hidden">
            <a href="{{ route('transactions.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                ⬅️ Kembali ke Daftar Transaksi
            </a>
            <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold px-3 py-1.5 rounded shadow transition cursor-pointer">
                🖨️ Cetak Nota Transaksi
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold tracking-wide">NOTA MUTASI STOK</h1>
                    <p class="text-xs text-blue-100 mt-1">ID Transaksi: #{{ $transaction->id }}</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase {{ $transaction->type == 'in' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        Barang {{ $transaction->type == 'in' ? 'Masuk' : 'Keluar' }}
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-6 divide-y divide-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Produk / Barang</label>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $transaction->product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Mutasi</label>
                        <p class="text-lg font-mono font-bold mt-1 {{ $transaction->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'in' ? '+' : '-' }} {{ $transaction->quantity }} Unit
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Input Sistem</label>
                        <p class="text-sm font-medium text-gray-700 mt-1">{{ $transaction->created_at->format('d F Y - H:i:s') }} WITA</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Petugas Operasional</label>
                        <p class="text-sm font-medium text-gray-700 mt-1">{{ $transaction->user->name }} <span class="text-xs text-gray-400">({{ ucfirst($transaction->user->role) }})</span></p>
                    </div>
                </div>

                <div class="pt-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Catatan / Keterangan Tambahan</label>
                    <div class="mt-2 p-3 bg-gray-50 rounded border border-gray-100 text-sm text-gray-600 italic">
                        @if($transaction->note)
                            "{{ $transaction->note }}"
                        @else
                            <span class="text-gray-400">Tidak ada catatan tambahan yang dilampirkan pada transaksi ini.</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium">Sistem Inventori Cerdas Berbasis Agen AI — Dicatat secara otomatis ke dalam Audit Logs.</p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, aside, .print\:hidden, button {
                display: none !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
            }
            .max-w-3xl {
                max-w: 100% !important;
            }
        }
    </style>
</x-default-layout>
