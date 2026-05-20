<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header Controls -->
        <div class="flex items-center gap-4">
            <a href="{{ route('transactions.index') }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Input Transaksi Stok</h2>
                <p class="text-sm text-slate-500 mt-0.5">Catat mutasi perubahan stok barang masuk atau keluar gudang.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 md:p-8">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Produk -->
                <div class="space-y-1.5">
                    <label for="product_id" class="block text-sm font-bold text-slate-700">Pilih Produk</label>
                    <select id="product_id" name="product_id" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" inherit required>
                        <option value="" disabled selected>-- Pilih Produk di Gudang --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Sisa Stok: {{ $product->stock }} unit)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Transaksi Custom Selector -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Transaksi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Pilihan Barang Masuk -->
                        <label class="relative flex items-center p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white cursor-pointer transition-all focus-within:ring-2 focus-within:ring-indigo-500">
                            <input type="radio" name="type" value="in" class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500" checked>
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-slate-900">📥 Barang Masuk</span>
                                <span class="block text-xs text-slate-400 mt-0.5">Jumlah stok gudang akan bertambah</span>
                            </div>
                        </label>
                        <!-- Pilihan Barang Keluar -->
                        <label class="relative flex items-center p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white cursor-pointer transition-all focus-within:ring-2 focus-within:ring-indigo-500">
                            <input type="radio" name="type" value="out" class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-slate-900">📤 Barang Keluar</span>
                                <span class="block text-xs text-slate-400 mt-0.5">Jumlah stok gudang akan berkurang</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Jumlah Perubahan Qty -->
                <div class="space-y-1.5">
                    <label for="quantity" class="block text-sm font-bold text-slate-700">Jumlah Perubahan (Qty)</label>
                    <input type="number"
                           id="quantity"
                           name="quantity"
                           min="1"
                           class="w-full bg-slate-50/50 border @error('quantity') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-indigo-500 @enderror rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all"
                           placeholder="Masukkan total kuantitas unit"
                           required>
                    @error('quantity')
                        <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Tambahan -->
                <div class="space-y-1.5">
                    <label for="note" class="block text-sm font-bold text-slate-700">Catatan / Keterangan Tambahan</label>
                    <input type="text"
                           id="note"
                           name="note"
                           placeholder="Misal: Restock dari Supplier rekanan / Retur kerusakan toko"
                           class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all">
                </div>

                <!-- Form Submit Button -->
                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white p-3.5 rounded-xl font-bold shadow-xs hover:shadow-md transition-all cursor-pointer text-sm tracking-wide">
                        Simpan & Update Stok Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
