<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index(): View
    {
        $transactions = Transaction::with(['product', 'creator'])
                                  ->latest()
                                  ->paginate(20);

        return view('transactions.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create(): View
    {
        $products = Product::active()->get();

        return view('transactions.create', ['products' => $products]);
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $validated['created_by'] = auth()->id();

        // Update product stock
        if ($validated['type'] === 'IN') {
            $product->increment('current_stock', $validated['quantity']);
        } else {
            if ($product->current_stock < $validated['quantity']) {
                return redirect()->back()
                               ->withErrors(['quantity' => 'Stok tidak cukup untuk pengurangan ini.']);
            }
            $product->decrement('current_stock', $validated['quantity']);
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')
                       ->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction): View
    {
        return view('transactions.show', ['transaction' => $transaction->load(['product', 'creator'])]);
    }

    /**
     * Get transactions for a product (API).
     */
    public function forProduct(Product $product)
    {
        $transactions = $product->transactions()
                              ->with('creator')
                              ->latest()
                              ->get();

        return response()->json($transactions);
    }

    /**
     * Get summary statistics.
     */
    public function summary()
    {
        $totalIn = Transaction::inbound()->sum('quantity');
        $totalOut = Transaction::outbound()->sum('quantity');
        $totalTransactions = Transaction::count();

        return response()->json([
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'total_transactions' => $totalTransactions,
            'net_flow' => $totalIn - $totalOut,
        ]);
    }
}
