<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan laporan ringkasan (auditor)
    public function index()
    {
        // Data ringkasan produk
        $totalProducts = Product::count();
        $stokKritis = Product::whereColumn('stock', '<=', 'min_stock')->get();
        $totalStok = Product::sum('stock');

        // Data ringkasan transaksi
        $totalTransactions = Transaction::count();
        $transactionsIn = Transaction::where('type', 'in')->sum('quantity');
        $transactionsOut = Transaction::where('type', 'out')->sum('quantity');

        // Data user per role
        $usersByRole = User::selectRaw('role, count(*) as total')
            ->groupBy('role')
            ->get();

        // Transaksi terbaru
        $recentTransactions = Transaction::with('product', 'user')
            ->latest()
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'totalProducts',
            'stokKritis',
            'totalStok',
            'totalTransactions',
            'transactionsIn',
            'transactionsOut',
            'usersByRole',
            'recentTransactions'
        ));
    }
}
