<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan form untuk membuat transaksi baru
    public function create()
    {
        // Ambil semua produk untuk dropdown
        $products = Product::with('supplier')->get();
        return view('transactions.create', compact('products'));
    }

    // Menampilkan daftar transaksi yang sudah dicatat
    public function index()
    {
        // Ambil transaksi terbaru dengan pagination
        $transactions = Transaction::with('product', 'user')
            ->latest()
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    // Menyimpan transaksi (masuk/keluar stok) ke database
    public function store(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($validated['product_id']);

        // Jika tipe transaksi "keluar" (barang keluar), stok harus cukup
        if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
            return back()
                ->withErrors(['quantity' => "Stok tidak cukup! Stok saat ini: {$product->stock} unit"])
                ->withInput();
        }

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'product_id' => $validated['product_id'],
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
        ]);

        // Update stok produk berdasarkan tipe transaksi
        if ($validated['type'] === 'in') {
            // Jika transaksi masuk, tambah stok
            $product->increment('stock', $validated['quantity']);
            $message = "Stok bertambah {$validated['quantity']} unit";
        } else {
            // Jika transaksi keluar, kurangi stok
            $product->decrement('stock', $validated['quantity']);
            $message = "Stok berkurang {$validated['quantity']} unit";
        }

        // Catat aktivitas ke audit log
        AuditHelper::logTransaction(
            $product->name,
            $validated['type'],
            $validated['quantity'],
            $validated['note'] ?? null
        );

        return redirect()
            ->route('transactions.index')
            ->with('success', "Transaksi berhasil dicatat! {$message}");
    }

    // Menampilkan detail transaksi
    public function show(string $id)
    {
        $transaction = Transaction::with('product', 'user')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }
}
