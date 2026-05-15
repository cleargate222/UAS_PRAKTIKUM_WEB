<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // USERS

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@test.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Auditor',
            'email' => 'auditor@test.com',
            'password' => Hash::make('password'),
            'role' => 'auditor',
        ]);

        User::create([
            'name' => 'Supplier',
            'email' => 'supplier@test.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
        ]);

        // PRODUCTS

        Product::create([
            'name' => 'Laptop ASUS',
            'stock' => 2,
            'min_stock' => 10,
            'description' => 'Laptop kantor',
            'supplier_id' => 5,
        ]);

        Product::create([
            'name' => 'Mouse Logitech',
            'stock' => 50,
            'min_stock' => 10,
            'description' => 'Mouse wireless',
            'supplier_id' => 5,
        ]);

        Product::create([
            'name' => 'Kabel LAN',
            'stock' => 0,
            'min_stock' => 5,
            'description' => 'Kabel jaringan',
            'supplier_id' => 5,
        ]);
    }
}