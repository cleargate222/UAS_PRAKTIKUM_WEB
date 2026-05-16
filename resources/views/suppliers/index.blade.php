<x-default-layout>
    <div class="space-y-4">
        <h1 class="text-2xl font-bold text-gray-800">Katalog Distribusi Saya</h1>
        <p class="text-sm text-gray-500">Berikut adalah daftar produk yang Anda pasok ke sistem inventori.</p>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 font-semibold">
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4">Sisa Stok Gudang</th>
                        <th class="p-4">Batas Minimum Keamanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-gray-700">
                    @forelse($myProducts as $prod)
                    <tr>
                        <td class="p-4 font-semibold">{{ $prod->name }}</td>
                        <td class="p-4">{{ $prod->stock }} unit</td>
                        <td class="p-4 text-gray-500">{{ $prod->min_stock }} unit</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-400">Anda belum menyuplai barang apapun.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>
