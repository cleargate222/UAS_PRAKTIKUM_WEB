<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        // Get statistics
        $totalProducts = Product::count();
        $activeProducts = Product::active()->count();
        $criticalStockCount = Product::criticalStock()->count();
        
        $totalTransactions = Transaction::count();
        $transactionsToday = Transaction::whereDate('created_at', today())->count();
        $inboundToday = Transaction::inbound()->whereDate('created_at', today())->sum('quantity');
        $outboundToday = Transaction::outbound()->whereDate('created_at', today())->sum('quantity');
        
        $totalUsers = User::count();
        $recentLogs = AuditLog::with('user')->latest()->limit(10)->get();

        // Get critical products
        $criticalProducts = Product::criticalStock()->limit(5)->get();

        // Get recent transactions
        $recentTransactions = Transaction::with(['product', 'creator'])
                                        ->latest()
                                        ->limit(10)
                                        ->get();

        // Get monthly transaction trend (last 12 months)
        $transactionTrend = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                                      ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)')
                                      ->groupBy('month')
                                      ->orderBy('month')
                                      ->get();

        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'criticalStockCount' => $criticalStockCount,
            'totalTransactions' => $totalTransactions,
            'transactionsToday' => $transactionsToday,
            'inboundToday' => $inboundToday,
            'outboundToday' => $outboundToday,
            'totalUsers' => $totalUsers,
            'criticalProducts' => $criticalProducts,
            'recentTransactions' => $recentTransactions,
            'recentLogs' => $recentLogs,
            'transactionTrend' => $transactionTrend,
        ]);
    }

    /**
     * Get dashboard statistics (API).
     */
    public function stats()
    {
        return response()->json([
            'total_products' => Product::count(),
            'critical_stock' => Product::criticalStock()->count(),
            'total_transactions' => Transaction::count(),
            'transactions_today' => Transaction::whereDate('created_at', today())->count(),
            'total_users' => User::count(),
        ]);
    }
}
