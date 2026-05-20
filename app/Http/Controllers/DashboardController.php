<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction; // Sudah dipastikan terimport
use App\Models\User;
use App\Ai\Agents\InventoryAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Enums\Lab;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $userId = Auth::id();
        $analysis = null;

        // 1. LOGIKA UNTUK SUPPLIER (Data produk yang dipasok oleh supplier ini)
        if ($role == 'supplier') {
            $myProducts = Product::where('supplier_id', $userId)->latest()->take(5)->get();
            $totalProducts = Product::where('supplier_id', $userId)->count();
            $stokKritis = Product::where('supplier_id', $userId)
                                 ->whereColumn('stock', '<=', 'min_stock')
                                 ->count();

            if ($request->has('analyze')) {
                $productsForAi = Product::where('supplier_id', $userId)->get();
                $customPrompt = "Anda adalah konsultan mitra supplier. Berdasarkan data produk yang SAYA PASOK berikut, berikan analisis barang mana yang kritis di gudang mereka, serta rekomendasi bagi saya untuk menjadwalkan pengiriman atau produksi ulang barang tersebut agar pasokan ke gudang tetap aman.";

                // Tambahkan data transaksi kosong untuk supplier karena mereka hanya fokus ke produk miliknya
                $analysis = $this->generateAiAnalysis($productsForAi, collect([]), $customPrompt);
            }

            return view('dashboard', compact('myProducts', 'totalProducts', 'stokKritis', 'analysis'));
        }

        // 2. LOGIKA UNTUK AUDITOR (Melihat riwayat transaksi sistem & stok global)
        if ($role == 'auditor') {
            // PERBAIKAN: Mengambil 5 transaksi keluar masuk barang terakhir secara real-time beserta relasi produknya
            $recentTransactions = Transaction::with('product')->latest()->take(5)->get();

            $totalProducts = Product::count();
            $stokKritis = Product::whereColumn('stock', '<=', 'min_stock')->count();

            if ($request->has('analyze')) {
                $productsForAi = Product::with('supplier')->get();
                // Mengambil semua transaksi terakhir untuk dianalisis oleh AI
                $transactionsForAi = Transaction::with('product')->latest()->take(10)->get();

                $customPrompt = "Anda adalah seorang Auditor Eksternal Sistem. Berdasarkan data seluruh inventaris gudang dan riwayat log transaksi keluar-masuk barang berikut, lakukan audit kelayakan operasional, deteksi jika ada anomali atau produk kritis yang berisiko langka akibat tingginya transaksi keluar, dan berikan rekomendasi kepatuhan manajemen stok.";

                $analysis = $this->generateAiAnalysis($productsForAi, $transactionsForAi, $customPrompt);
            }

            return view('dashboard', compact('recentTransactions', 'totalProducts', 'stokKritis', 'analysis'));
        }

        // 3. LOGIKA UNTUK ADMIN & STAFF (Melihat produk baru & transaksi keluar masuk)
        $latestProducts = Product::latest()->take(5)->get();

        // PERBAIKAN: Agar Staff dan Admin juga bisa melihat riwayat keluar masuk barang di dashboard (jika dibutuhkan oleh view kamu)
        $recentTransactions = Transaction::with('product')->latest()->take(5)->get();

        $totalProducts = Product::count();
        $stokKritis = Product::whereColumn('stock', '<=', 'min_stock')->count();

        if ($request->has('analyze')) {
            $productsForAi = Product::with('supplier')->get();
            // Mengambil data transaksi terakhir untuk memberikan konteks barang mana yang paling cepat habis
            $transactionsForAi = Transaction::with('product')->latest()->take(10)->get();

            $customPrompt = "Anda adalah Kepala Operasional Gudang. Berdasarkan data stok saat ini dan riwayat aktivitas transaksi keluar-masuk barang terbaru, segera identifikasi barang yang berstatus kritis akibat perputaran yang cepat, lalu buat laporan pengadaan harian (purchase request) yang wajib dipesan ke supplier.";

            $analysis = $this->generateAiAnalysis($productsForAi, $transactionsForAi, $customPrompt);
        }

        // Pastikan 'recentTransactions' juga diikutkan di compact admin/staff jika view memanggilnya
        return view('dashboard', compact('latestProducts', 'recentTransactions', 'totalProducts', 'stokKritis', 'analysis'));
    }

    /**
     * Helper fungsi internal yang diperbarui untuk menerima data transaksi keluar-masuk
     */
    private function generateAiAnalysis($products, $transactions, $customPrompt)
    {
        if ($products->isEmpty() && $transactions->isEmpty()) {
            return "Belum ada data produk atau transaksi di dalam database untuk dianalisis.";
        }

        // 1. Mengubah data produk menjadi string teks
        $dataProdukTeks = $products->map(function ($item) {
            $namaSupplier = isset($item->supplier) ? $item->supplier->name : 'Tanpa Supplier';
            return "Barang: {$item->name} (Stok: {$item->stock}/Min: {$item->min_stock}, Supplier: {$namaSupplier})";
        })->implode(', ');

        // 2. Mengubah data aktivitas transaksi keluar-masuk menjadi string teks untuk dibaca AI
        $dataTransaksiTeks = $transactions->map(function ($tx) {
            $namaBarang = $tx->product ? $tx->product->name : 'Produk Dihapus';
            $tipe = $tx->type == 'in' ? 'Masuk (+)' : 'Keluar (-)';
            return "[Tgl: {$tx->created_at->format('d/m H:i')}] Barang: {$namaBarang}, Tipe: {$tipe}, Jumlah: {$tx->quantity} unit";
        })->implode(', ');

        // Gabungkan semua data menjadi satu kesatuan konteks untuk Gemini
        $konteksFinal = "{$customPrompt} \n\nDATA STOK PRODUK: ({$dataProdukTeks}).";

        if ($transactions->isNotEmpty()) {
            $konteksFinal .= " \n\nRIWAYAT AKTIVITAS TRANSAKSI TERAKHIR: ({$dataTransaksiTeks}).";
        }

        // Jalankan prompt AI SDK
        return InventoryAgent::make()->prompt($konteksFinal, provider: Lab::Gemini);
    }
}
