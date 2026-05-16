<x-default-layout>
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h1>

        <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Stok Awal</label>
                    <input type="number" name="stock" min="0" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Batas Minimum Stok</label>
                    <input type="number" name="min_stock" min="0" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Pilih Supplier</label>
                <select name="supplier_id" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Deskripsi Barang (Opsional)</label>
                <textarea name="description" rows="3" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-semibold hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 cursor-pointer">Simpan Produk</button>
            </div>
        </form>
    </div>
</x-default-layout>
