<x-default-layout>
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok Barang</h1>
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition cursor-pointer">
                + Tambah Produk
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm font-semibold">
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Stok Saat Ini</th>
                        <th class="p-4">Batas Minimum</th>
                        <th class="p-4">Supplier</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @foreach($products as $product)
                    <tr class="{{ $product->stock <= $product->min_stock ? 'bg-red-50/50' : '' }}">
                        <td class="p-4 font-medium">{{ $product->name }}</td>
                        <td class="p-4">
                            <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-bold' : '' }}">
                                {{ $product->stock }} unit
                            </span>
                            @if($product->stock <= $product->min_stock)
                                <span class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-semibold">Restock!</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500">{{ $product->min_stock }} unit</td>
                        <td class="p-4">{{ $product->supplier->name }}</td>
                        <td class="p-4 flex justify-center space-x-2">
                            <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="text-amber-600 hover:text-amber-800 font-semibold">Edit</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold cursor-pointer">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-default-layout>
