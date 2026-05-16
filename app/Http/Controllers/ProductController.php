<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index(): View
    {
        $products = Product::all();
        $criticalProducts = Product::criticalStock()->get();

        return view('products.index', [
            'products' => $products,
            'criticalCount' => $criticalProducts->count(),
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku|max:100',
            'description' => 'nullable|string',
            'current_stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
                       ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $transactions = $product->transactions()
                              ->latest()
                              ->paginate(15);

        return view('products.show', [
            'product' => $product,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'current_stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);

        return redirect()->route('products.show', $product)
                       ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                       ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Get critical stock products (API endpoint).
     */
    public function criticalStock()
    {
        return response()->json(Product::criticalStock()->get());
    }
}
