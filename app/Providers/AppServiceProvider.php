<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Supplier;
use App\Models\User;
use App\Observers\AuditObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define gates for authorization

        // Manage Products (Admin only)
        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'super_admin']);
        });

        // Record Transactions (Admin & Staff)
        Gate::define('record-transactions', function ($user) {
            return in_array($user->role, ['admin', 'staff', 'super_admin']);
        });

        // Manage Suppliers (Admin & Supplier)
        Gate::define('manage-suppliers', function ($user) {
            return in_array($user->role, ['admin', 'supplier', 'super_admin']);
        });

        // Manage Users (Super Admin & Admin)
        Gate::define('manage-users', function ($user) {
            return in_array($user->role, ['super_admin', 'admin']);
        });

        // View Audit Logs (Super Admin & Auditor)
        Gate::define('view-audit-logs', function ($user) {
            return in_array($user->role, ['super_admin', 'auditor']);
        });

        // Super Admin only
        Gate::define('is-super-admin', function ($user) {
            return $user->role === 'super_admin';
        });

        // Admin or above
        Gate::define('is-admin', function ($user) {
            return in_array($user->role, ['super_admin', 'admin']);
        });

        // Register model observers for automatic audit logging
        Product::observe(AuditObserver::class);
        Transaction::observe(AuditObserver::class);
        Supplier::observe(AuditObserver::class);
        User::observe(AuditObserver::class);
    }
}
