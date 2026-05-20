<x-default-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Header Controls -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="p-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl transition-colors shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <span class="text-xs font-bold text-indigo-600 tracking-wider uppercase">Detail Manufaktur</span>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $product->name }}</h2>
                </div>
            </div>

            <a href="{{ route('products.edit', $product->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs border border-slate-200/50 transition-all flex items-center gap-1.5">
                ✏️ Edit Item
            </a>
        </div>

        <!-- Main Info Card -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
            <!-- Grid Metrik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 border-b border-slate-100 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                <!-- Blok Sisa Stok -->
                <div class="p-6 space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Volume Stok Tersedia</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-mono font-black text-slate-900">{{ $product->stock }}</span>
                        <span class="text-sm font-semibold text-slate-500">unit di rak</span>
                    </div>

                    <div class="pt-2">
                        @if($product->stock <= $product->min_stock)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                ⚠️ Di Bawah Batas Aman
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                ✓ Kuantitas Memadai
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Blok Batas Keamanan -->
                <div class="p-6 space-y-2 bg-slate-50/30">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Ambang Batas Minimum</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-mono font-bold text-slate-700">{{ $product->min_stock }}</span>
                        <span class="text-sm font-medium text-slate-500">unit pengaman</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed pt-2">Sistem otomatis memberi tanda bahaya retur/restock jika kuantitas real-time menyentuh angka ini.</p>
                </div>
            </div>

            <!-- List Atribut Detail Tambahannya -->
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1">
                    <span class="text-sm font-bold text-slate-400 uppercase">Perusahaan Pemasok</span>
                    <span class="text-sm font-bold text-slate-800 sm:col-span-2 flex items-center gap-1">
                        🏢 {{ $product->supplier->name }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-t border-slate-50 pt-4">
                    <span class="text-sm font-bold text-slate-400 uppercase">Kontak Supplier</span>
                    <span class="text-sm font-medium text-slate-600 sm:col-span-2">
                        {{ $product->supplier->email ?? 'Tidak ada data email resmi' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-t border-slate-50 pt-4">
                    <span class="text-sm font-bold text-slate-400 uppercase">Deskripsi / Catatan Fisik</span>
                    <span class="text-sm text-slate-600 sm:col-span-2 leading-relaxed italic">
                        {{ $product->description ?? 'Tidak ada ringkasan deskripsi atau catatan khusus untuk produk ini.' }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</x-default-layout>
