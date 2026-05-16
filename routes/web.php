<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman yang bisa diakses SEMUA role yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Khusus Super Admin (Kelola User)
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Khusus Admin & Staff (Manajemen Stok & Transaksi)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});

// Khusus Auditor (Cek Log & Laporan)
Route::middleware(['auth', 'role:auditor,super_admin'])->group(function () {
    Route::get('/logs', [LogController::class, 'index']);
    Route::get('/report', [ReportController::class, 'index']);
});

// Khusus Supplier (Barang Milik Sendiri)
Route::middleware(['auth', 'role:supplier'])->group(function () {
    Route::get('/my-supply', [SupplierController::class, 'index']);
});


// Route untuk Login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
