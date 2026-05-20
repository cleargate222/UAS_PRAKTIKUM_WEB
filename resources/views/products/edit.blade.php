<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Produk</h2>
                <p class="text-sm text-slate-500 mt-0.5">Mengubah data informasi untuk komoditas <span class="font-semibold text-slate-700">"{{ $product->name }}"</span></p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 md:p-8">
            <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Jumlah Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" required>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Batas Minimum</label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" required>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Supplier Perujuk</label>
                    <select name="supplier_id" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" required>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('products.index') }}" class="text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-xs hover:shadow-md transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
