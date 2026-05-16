# DOKUMENTASI SISTEM FORM TRANSAKSI BARANG

## Deskripsi
Sistem form transaksi barang memungkinkan staff untuk mencatat transaksi masuk (barang masuk/pembelian) dan transaksi keluar (barang keluar/penjualan) dengan otomatis memperbarui stok produk di database.

## Fitur Utama

### 1. **Form Input Transaksi** (transactions/create.blade.php)
Form yang user-friendly untuk staff melakukan transaksi dengan fitur:
- ✅ Dropdown pilih produk dengan tampil stok & supplier
- ✅ Radio button pilih tipe transaksi (Masuk/Keluar)
- ✅ Input jumlah barang dengan validasi
- ✅ Textarea catatan opsional (max 500 karakter)
- ✅ Info dinamis stok, min stok, dan supplier
- ✅ Counter karakter real-time untuk catatan
- ✅ Error handling yang informatif

### 2. **Daftar Transaksi** (transactions/index.blade.php)
Halaman yang menampilkan:
- ✅ Riwayat semua transaksi dengan pagination (15 per halaman)
- ✅ Filter badge untuk tipe transaksi (Masuk/Keluar)
- ✅ Informasi staff yang melakukan transaksi
- ✅ Tanggal & waktu dengan format human-readable
- ✅ Statistik harian (total masuk, total keluar, net)
- ✅ Link detail transaksi

### 3. **Detail Transaksi** (transactions/show.blade.php)
Halaman detail yang menampilkan:
- ✅ Informasi lengkap transaksi
- ✅ Detail produk (nama, supplier, stok)
- ✅ Info staff yang melakukan transaksi
- ✅ Tanggal & waktu lengkap
- ✅ Catatan transaksi
- ✅ Badge status transaksi

## Route Configuration

### Routes di `routes/web.php`
```php
// Khusus Admin & Staff (Manajemen Stok & Transaksi)
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    // ... routes lainnya ...
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});
```

## Controller Methods

### 1. `create()` - Tampilkan Form Transaksi
```php
public function create()
{
    // Ambil semua produk untuk dropdown
    $products = Product::with('supplier')->get();
    return view('transactions.create', compact('products'));
}
```

**Fitur:**
- Mengambil semua produk dengan relasi supplier
- Menampilkan form input transaksi
- Menampilkan info produk (stok, min_stok, supplier)

### 2. `index()` - Daftar Transaksi
```php
public function index()
{
    // Ambil transaksi terbaru dengan pagination
    $transactions = Transaction::with('product', 'user')
        ->latest()
        ->paginate(15);
    
    return view('transactions.index', compact('transactions'));
}
```

**Fitur:**
- Menampilkan riwayat transaksi
- Pagination 15 item per halaman
- Sorting by latest transactions
- Relasi product dan user untuk menampilkan detail

### 3. `store()` - Simpan Transaksi
```php
public function store(Request $request)
{
    // 1. Validasi input
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'type' => 'required|in:in,out',
        'quantity' => 'required|integer|min:1',
        'note' => 'nullable|string|max:500',
    ]);

    // 2. Cari produk
    $product = Product::findOrFail($validated['product_id']);

    // 3. Validasi stok untuk transaksi keluar
    if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
        return back()
            ->withErrors(['quantity' => "Stok tidak cukup! Stok saat ini: {$product->stock} unit"])
            ->withInput();
    }

    // 4. Simpan transaksi ke database
    $transaction = Transaction::create([
        'product_id' => $validated['product_id'],
        'user_id' => Auth::id(),
        'type' => $validated['type'],
        'quantity' => $validated['quantity'],
        'note' => $validated['note'] ?? null,
    ]);

    // 5. Update stok produk
    if ($validated['type'] === 'in') {
        $product->increment('stock', $validated['quantity']);
        $message = "Stok bertambah {$validated['quantity']} unit";
    } else {
        $product->decrement('stock', $validated['quantity']);
        $message = "Stok berkurang {$validated['quantity']} unit";
    }

    // 6. Catat audit log
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
```

**Proses:**
1. **Validasi Input**: Memastikan semua field required terisi dengan benar
2. **Cek Stok**: Jika transaksi keluar, pastikan stok cukup
3. **Simpan DB**: Simpan transaksi ke tabel `transactions`
4. **Update Stok**: Otomatis tambah/kurangi stok di tabel `products`
5. **Audit Log**: Catat aktivitas ke audit log
6. **Response**: Redirect dengan pesan success

### 4. `show()` - Detail Transaksi
```php
public function show(string $id)
{
    $transaction = Transaction::with('product', 'user')->findOrFail($id);
    return view('transactions.show', compact('transaction'));
}
```

**Fitur:**
- Menampilkan detail lengkap transaksi
- Relasi dengan product dan user

## Validasi & Error Handling

### Validasi Input
```php
$validated = $request->validate([
    'product_id' => 'required|exists:products,id',           // Produk harus dipilih & ada
    'type' => 'required|in:in,out',                          // Tipe harus masuk atau keluar
    'quantity' => 'required|integer|min:1',                  // Jumlah harus angka positif
    'note' => 'nullable|string|max:500',                     // Catatan opsional, max 500 char
]);
```

### Validasi Stok (Transaksi Keluar)
```php
if ($validated['type'] === 'out' && $product->stock < $validated['quantity']) {
    return back()
        ->withErrors(['quantity' => "Stok tidak cukup! Stok saat ini: {$product->stock} unit"])
        ->withInput();
}
```

**Penjelasan:**
- Jika transaksi tipe "keluar" dan stok < jumlah request
- Return back dengan error message + input yang diisi user tetap terjaga

## Database Schema

### Tabel transactions
```sql
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('in', 'out') NOT NULL,  -- in = masuk, out = keluar
    quantity INT NOT NULL,              -- jumlah barang
    note TEXT,                          -- catatan opsional
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Tabel products (relevant columns)
```sql
stock INT DEFAULT 0,           -- stok yang berubah otomatis
min_stock INT DEFAULT 0,       -- minimum stok
```

## Alur Kerja

### Transaksi Barang Masuk
```
1. Staff membuka form transaksi (/transactions/create)
2. Pilih produk dari dropdown
3. Pilih "Barang Masuk"
4. Input jumlah + catatan (opsional)
5. Click "Simpan Transaksi"
6. Database:
   - INSERT ke tabel transactions
   - UPDATE products.stock += quantity
   - INSERT ke tabel activity_logs (audit)
7. Redirect ke daftar transaksi dengan pesan success
```

### Transaksi Barang Keluar
```
1. Staff membuka form transaksi (/transactions/create)
2. Pilih produk dari dropdown
3. Pilih "Barang Keluar"
4. Input jumlah + catatan (opsional)
5. Click "Simpan Transaksi"
6. Sistem validasi:
   - Jika stok < jumlah → ERROR: "Stok tidak cukup!"
   - Jika stok >= jumlah → LANJUT
7. Database:
   - INSERT ke tabel transactions
   - UPDATE products.stock -= quantity
   - INSERT ke tabel activity_logs (audit)
8. Redirect ke daftar transaksi dengan pesan success
```

## Integrasi Audit Log

Setiap transaksi otomatis mencatat aktivitas:

**Format Log:**
```
Stok Masuk: Laptop Dell (Qty: 5) - Catatan: Pembelian dari supplier
Stok Keluar: Monitor Samsung (Qty: 2)
Stok Masuk: Keyboard Mechanical (Qty: 10) - Catatan: Restock minggu ini
```

**Auditor dapat lihat:**
- Daftar lengkap transaksi di `/logs`
- Siapa yang melakukan transaksi
- Produk apa yang ditransaksikan
- Waktu transaksi dilakukan
- Catatan tambahan dari staff

## Keamanan

1. **Middleware Auth**: Hanya user yang login bisa akses
2. **Role-Based**: Hanya admin & staff yang bisa akses transaksi
3. **Validasi Input**: Semua input divalidasi di server-side
4. **Stok Guard**: Tidak bisa keluar stok lebih dari yang ada
5. **Audit Trail**: Semua aktivitas tercatat untuk audit
6. **User Tracking**: Setiap transaksi tercatat siapa yang melakukannya

## Fitur JavaScript

### Update Info Produk Dinamis
```javascript
function updateProductInfo() {
    const select = document.getElementById('product_id');
    const selectedOption = select.options[select.selectedIndex];
    
    // Menampilkan info stok & supplier
    document.getElementById('currentStock').textContent = 
        selectedOption.getAttribute('data-stock');
}
```

### Counter Karakter Catatan
```javascript
document.getElementById('note').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});
```

## View Features

### Responsive Design
- ✅ Mobile-friendly bootstrap grid
- ✅ Responsive table dengan scroll di mobile
- ✅ Button grup yang responsive

### User Experience
- ✅ Icon untuk visual clarity
- ✅ Color badges untuk status
- ✅ Error message yang jelas
- ✅ Success notification
- ✅ Loading state via submit button
- ✅ Panduan penggunaan

### Informasi Dinamis
- ✅ Stok real-time dari database
- ✅ Supplier info otomatis
- ✅ Statistik harian transaksi
- ✅ Timestamp human-readable

## Best Practice

1. **Jangan hapus transaksi** - Transaksi adalah historical record
2. **Gunakan catatan** - Untuk dokumentasi perubahan stok
3. **Monitor stok minimum** - Audit log akan alert via report
4. **Review transaksi** - Auditor harus review log secara berkala
5. **Validasi input** - Pastikan produk & jumlah benar sebelum submit

## Troubleshooting

### Error: "Stok tidak cukup"
- **Penyebab**: Transaksi keluar melebihi stok saat ini
- **Solusi**: Kurangi jumlah atau pesan stok lebih dulu

### Error: "Produk tidak ditemukan"
- **Penyebab**: Produk dihapus atau tidak ada di database
- **Solusi**: Refresh halaman & pilih produk yang berbeda

### Transaksi tidak terjadi
- **Penyebab**: Validasi gagal atau server error
- **Solusi**: Cek console browser untuk error detail

## Expansion Ideas

1. **Batch Import**: Import transaksi dari Excel
2. **Forecast**: Prediksi stok berdasarkan transaksi history
3. **Alert**: Notifikasi email ketika stok mencapai minimum
4. **Report**: Export transaksi ke PDF/Excel
5. **Multi-Warehouse**: Support untuk multiple gudang
6. **Serial Number**: Track item individual dengan serial
7. **Price Tracking**: Catat harga per transaksi
