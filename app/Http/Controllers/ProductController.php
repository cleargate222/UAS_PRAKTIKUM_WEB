<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::with('supplier')->paginate(10);
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        $suppliers = User::where('role', 'supplier')->get();
        return view('products.create', compact('suppliers'));
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier_id' => 'required|exists:users,id',
        ]);

        // Simpan produk baru ke database
        $product = Product::create($validated);

        // Catat aktivitas ke audit log
        AuditHelper::logCreateProduct($product);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan detail produk
    public function show(string $id)
    {
        $product = Product::with('supplier')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Menampilkan form untuk mengedit produk
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = User::where('role', 'supplier')->get();
        return view('products.edit', compact('product', 'suppliers'));
    }

    // Mengupdate produk di database
    public function update(Request $request, string $id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Validasi input dari user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'supplier_id' => 'required|exists:users,id',
        ]);

        // Simpan perubahan yang terjadi
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($product->$key != $value) {
                $changes[$key] = $value;
            }
        }

        // Update data produk
        $product->update($validated);

        // Catat aktivitas ke audit log jika ada perubahan
        if (!empty($changes)) {
            AuditHelper::logUpdateProduct($product, $changes);
        }

        return redirect()->route('products.show', $id)->with('success', 'Produk berhasil diperbarui');
    }

    // Menghapus produk dari database
    public function destroy(string $id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Simpan nama produk sebelum dihapus
        $productName = $product->name;

        // Hapus produk dari database
        $product->delete();

        // Catat aktivitas ke audit log
        AuditHelper::logDeleteProduct($productName);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
