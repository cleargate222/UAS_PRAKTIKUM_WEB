<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Data Dasar untuk Dashboard
        $totalProducts = Product::count();
        $stokKritis = Product::whereColumn('stock', '<=', 'min_stock')->count();

        // Logika tampilan berdasarkan Role
        if ($role == 'supplier') {
            // Supplier hanya melihat barang miliknya
            $myProducts = Product::where('supplier_id', Auth::id())->get();
            return view('dashboard', compact('myProducts', 'totalProducts', 'stokKritis'));
        }

        if ($role == 'auditor') {
            // Auditor melihat ringkasan aktivitas
            $recentTransactions = Transaction::with('product')->latest()->take(5)->get();
            return view('dashboard', compact('recentTransactions', 'totalProducts', 'stokKritis'));
        }

        // Untuk Admin & Staff
        $latestProducts = Product::latest()->take(5)->get();
        return view('dashboard', compact('latestProducts', 'totalProducts', 'stokKritis'));
    }
}
