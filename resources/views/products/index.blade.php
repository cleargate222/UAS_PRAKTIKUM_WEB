<x-default-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Stok Barang</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola kuantitas item, ambang batas minimum, serta hak distribusi supplier.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 flex items-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Produk
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Nama Produk</th>
                            <th class="p-4">Stok Saat Ini</th>
                            <th class="p-4">Batas Minimum</th>
                            <th class="p-4">Supplier</th>
                            <th class="p-4 text-center pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @forelse($products as $product)
                        @php
                            // Mengamankan nilai jika kolom min_stock kosong di database
                            $minStock = $product->min_stock ?? 0;
                            $isLow = $product->stock <= $minStock;
                        @endphp
                        <tr class="hover:bg-slate-50/40 transition-colors {{ $isLow ? 'bg-rose-50/30 hover:bg-rose-50/50' : '' }}">
                            <!-- Nama Produk -->
                            <td class="p-4 pl-6 font-bold text-slate-900">
                                {{ $product->name }}
                            </td>

                            <!-- Stok Saat Ini -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-base {{ $isLow ? 'text-rose-600' : 'text-slate-800' }}">
                                        {{ $product->stock ?? 0 }} <span class="text-xs font-sans font-medium text-slate-400">unit</span>
                                    </span>
                                    @if($isLow)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-100 text-rose-700 animate-pulse uppercase tracking-wide">
                                            🚨 Restock!
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Batas Minimum -->
                            <td class="p-4 text-slate-500 font-mono font-medium">
                                {{ $minStock }} <span class="text-xs font-sans">unit</span>
                            </td>

                            <!-- Supplier (Amankan dari Error 500 jika relasi kosong) -->
                            <td class="p-4 text-slate-600 font-medium">
                                🏢 {{ $product->supplier->name ?? 'Supplier Tidak Ditemukan' }}
                            </td>

                            <!-- Aksi Menu -->
                            <td class="p-4 text-center pr-6">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Detail Button -->
                                    <a href="{{ route('products.show', $product->id) }}" class="p-2 bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 rounded-xl transition-colors" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <!-- Edit Button -->
                                    <a href="{{ route('products.edit', $product->id) }}" class="p-2 bg-slate-100 hover:bg-amber-50 text-slate-600 hover:text-amber-600 rounded-xl transition-colors" title="Ubah">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 rounded-xl transition-colors cursor-pointer" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 italic">
                                Belum ada data produk terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Amankan pagination dari error -->
        @if(method_exists($products, 'links'))
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-default-layout>
