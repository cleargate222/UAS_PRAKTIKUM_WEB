<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    // Menampilkan produk milik supplier yang sedang login
    public function index()
    {
        // Ambil data produk milik supplier yang sedang login
        $myProducts = Product::where('supplier_id', Auth::id())->paginate(10);
        return view('suppliers.index', compact('myProducts'));
    }
}
