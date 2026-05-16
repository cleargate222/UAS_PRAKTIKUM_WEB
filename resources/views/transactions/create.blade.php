<x-default-layout>
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Input Transaksi Stok</h1>

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Pilih Produk</label>
                <select name="product_id" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Sisa Stok: {{ $product->stock }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                <div class="mt-2 flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="in" class="text-blue-600" checked>
                        <span class="ml-2 text-sm font-medium text-gray-700">Barang Masuk (Stok Bertambah)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="out" class="text-blue-600">
                        <span class="ml-2 text-sm font-medium text-gray-700">Barang Keluar (Stok Berkurang)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Jumlah Perubahan (Qty)</label>
                <input type="number" name="quantity" min="1" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                @error('quantity')
                    <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Catatan Tambahan</label>
                <input type="text" name="note" placeholder="Misal: Restock dari Supplier A / Retur barang rusak" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="submit" class="w-full bg-blue-600 text-white p-2.5 rounded font-bold hover:bg-blue-700 transition cursor-pointer">
                    Simpan & Update Stok
                </button>
            </div>
        </form>
    </div>
</x-default-layout>
