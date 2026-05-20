<x-default-layout>
    <div class="space-y-8">
        <!-- Header Section -->
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Distribusi</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar produk yang Anda pasok ke dalam sistem inventori saat ini.</p>
        </div>

        <!-- Katalog Table -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 pl-6">Nama Barang</th>
                            <th class="p-4">Sisa Stok</th>
                            <th class="p-4">Status & Keamanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($myProducts as $prod)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Nama Barang -->
                            <td class="p-4 pl-6 font-bold text-slate-800">
                                {{ $prod->name }}
                            </td>

                            <!-- Stok (Dengan visual angka) -->
                            <td class="p-4 font-mono font-bold text-slate-700">
                                {{ number_format($prod->stock) }} <span class="text-xs text-slate-400 font-medium">unit</span>
                            </td>

                            <!-- Visual Status & Progress -->
                            <td class="p-4 w-64">
                                <div class="flex items-center gap-4">
                                    <!-- Progress Bar -->
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        @php
                                            $percentage = ($prod->stock / ($prod->min_stock * 2)) * 100;
                                            $color = $prod->stock <= $prod->min_stock ? 'bg-rose-500' : 'bg-indigo-500';
                                        @endphp
                                        <div class="h-full {{ $color }} rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                    </div>

                                    <!-- Label status -->
                                    @if($prod->stock <= $prod->min_stock)
                                        <span class="text-[10px] font-black uppercase text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-100">Low Stock</span>
                                    @else
                                        <span class="text-[10px] font-black uppercase text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Aman</span>
                                    @endif
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">Batas Min: {{ $prod->min_stock }} unit</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center text-slate-400 italic">
                                Anda belum menyuplai barang apapun ke dalam sistem.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-default-layout>
