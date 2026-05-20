<x-default-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('products.index') }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Produk Baru</h2>
                <p class="text-sm text-slate-500 mt-0.5">Daftarkan produk baru ke dalam sistem logistik pergudangan.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 md:p-8">
            <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Nama Produk</label>
                    <input type="text" name="name" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" placeholder="Masukkan nama barang spesifik" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Stok Awal</label>
                        <input type="number" name="stock" min="0" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" placeholder="0" required>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-bold text-slate-700">Batas Minimum Stok</label>
                        <input type="number" name="min_stock" min="0" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" placeholder="Misal: 10" required>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Pilih Supplier Mitra</label>
                    <select name="supplier_id" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" required>
                        <option value="" disabled selected>-- Pilih Perusahaan Penyuplai --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-slate-700">Deskripsi Barang <span class="text-xs font-normal text-slate-400">(Opsional)</span></label>
                    <textarea name="description" rows="3" class="w-full bg-slate-50/50 border border-slate-200 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm text-slate-900 focus:outline-hidden focus:ring-2 focus:bg-white transition-all" placeholder="Tambahkan catatan detail spesifikasi atau lokasi rak penyimpanan barang..."></textarea>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('products.index') }}" class="text-center bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-xs hover:shadow-md transition-all cursor-pointer">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
