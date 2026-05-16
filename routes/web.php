<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public routes
Route::middleware('guest')->group(function () {
    // Login & Register routes will be added by Laravel Breeze/Fortify if installed
    // For now, we'll use these as placeholders
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (Manage Stok) - Only Admin
    Route::middleware('can:manage-products')->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/api/products/critical', [ProductController::class, 'criticalStock'])->name('products.critical');
    });

    // Transactions - Admin & Staff
    Route::middleware('can:record-transactions')->group(function () {
        Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('/api/transactions/for-product/{product}', [TransactionController::class, 'forProduct'])->name('transactions.for-product');
        Route::get('/api/transactions/summary', [TransactionController::class, 'summary'])->name('transactions.summary');
    });

    // Suppliers - Admin & Supplier
    Route::middleware('can:manage-suppliers')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::get('/api/suppliers/active', [SupplierController::class, 'activeSuppliers'])->name('suppliers.active');
    });

    // Users Management - Super Admin & Admin only
    Route::middleware('can:manage-users')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/api/users/by-role', [UserController::class, 'byRole'])->name('users.by-role');
    });

    // Audit Logs - Super Admin & Auditor only
    Route::middleware('can:view-audit-logs')->group(function () {
        Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
        Route::get('/api/audit-logs/for-record', [AuditLogController::class, 'forRecord'])->name('audit-logs.for-record');
        Route::get('/api/audit-logs/summary', [AuditLogController::class, 'summary'])->name('audit-logs.summary');
        Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
    });

    // API Dashboard
    Route::get('/api/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
});

// API routes (can be accessed with bearer token)
Route::prefix('api')->group(function () {
    // Public API endpoints can go here
    Route::get('/status', function () {
        return response()->json(['status' => 'ok']);
    });
});

