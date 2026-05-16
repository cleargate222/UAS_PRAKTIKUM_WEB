<x-default-layout>
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->name }}</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jumlah Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Batas Minimum</label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Supplier</label>
                <select name="supplier_id" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-blue-500" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <button type="submit" class="bg-amber-500 text-white px-6 py-2 rounded font-bold hover:bg-amber-600 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-default-layout>
