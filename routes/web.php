<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman yang bisa diakses SEMUA role yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

// Khusus Super Admin (Kelola User)
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});

// Khusus Admin & Staff (Manajemen Stok & Transaksi)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('/transactions', [TransactionController::class, 'store']);
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
