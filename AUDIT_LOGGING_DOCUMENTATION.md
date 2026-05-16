# DOKUMENTASI SISTEM AUDIT LOGGING

## Deskripsi
Sistem audit logging otomatis mencatat semua aktivitas penting yang dilakukan oleh pengguna dalam aplikasi. Data aktivitas disimpan ke tabel `activity_logs` untuk keperluan audit dan compliance.

## Fitur yang Dicatat

### 1. Manajemen Produk (ProductController)
- **Menambah Produk** - Nama produk, stok awal, dan min_stock dicatat
- **Mengubah Produk** - Detail perubahan (nama, stok, min_stock, deskripsi) dicatat
- **Menghapus Produk** - Nama produk yang dihapus dicatat

### 2. Transaksi Stok (TransactionController)
- **Stok Masuk** - Nama produk, jumlah masuk, dan catatan dicatat
- **Stok Keluar** - Nama produk, jumlah keluar, dan catatan dicatat

### 3. Manajemen User (UserController)
- **Menambah User** - Nama, email, dan role user baru dicatat
- **Mengubah User** - Perubahan data user dicatat
- **Menghapus User** - Nama dan email user yang dihapus dicatat

### 4. Manajemen Profil (ProfileController)
- **Update Profil** - Perubahan profil pribadi user dicatat

### 5. Autentikasi (AuthController)
- **Login** - Nama user dan email saat login dicatat
- **Logout** - Nama user dan email saat logout dicatat

## Arsitektur Sistem

### File-File Utama

```
app/
├── Helpers/
│   └── AuditHelper.php          # Class helper untuk logging
├── Controllers/
│   ├── ProductController.php     # Sudah terintegrasi audit
│   ├── TransactionController.php # Sudah terintegrasi audit
│   ├── UserController.php        # Sudah terintegrasi audit
│   ├── ProfileController.php     # Sudah terintegrasi audit
│   └── AuthController.php        # Sudah terintegrasi audit
├── Models/
│   ├── ActivityLog.php           # Model untuk menyimpan log
│   ├── Product.php
│   ├── Transaction.php
│   └── User.php
├── Observers/
│   └── ProductObserver.php       # Observer untuk Product model
└── Providers/
    └── AppServiceProvider.php    # Service provider (observer terdaftar)
```

## Cara Penggunaan

### Menggunakan AuditHelper

```php
use App\Helpers\AuditHelper;

// Logging aktivitas umum
AuditHelper::log("Deskripsi aktivitas apa saja");

// Logging aktivitas spesifik
AuditHelper::logCreateProduct($product);      // Logging produk baru
AuditHelper::logUpdateProduct($product, $changes); // Logging perubahan produk
AuditHelper::logDeleteProduct($productName);  // Logging penghapusan produk
AuditHelper::logTransaction($productName, $type, $quantity, $note); // Logging transaksi
AuditHelper::logCreateUser($user);            // Logging user baru
AuditHelper::logUpdateUser($user);            // Logging perubahan user
AuditHelper::logDeleteUser($userName, $email); // Logging penghapusan user
AuditHelper::logLogin($user);                 // Logging login
AuditHelper::logLogout($user);                // Logging logout
AuditHelper::logUpdateProfile($userName);     // Logging update profil
```

## Tabel Database

### activity_logs
```sql
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    activity TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Contoh Log yang Tersimpan

1. **Stok Masuk**
   ```
   Stok Masuk: Laptop Dell XPS (Qty: 5) - Catatan: Pembelian dari supplier
   ```

2. **Stok Keluar**
   ```
   Stok Keluar: Keyboard Mechanical (Qty: 2)
   ```

3. **Update Produk**
   ```
   Mengubah produk: Monitor Samsung 24" (Stok: 15, Min Stok: 5)
   ```

4. **Hapus Produk**
   ```
   Menghapus produk: Mouse Wireless Lama
   ```

5. **Manajemen User**
   ```
   Menambah user: Budi Santoso (budi@example.com) - Role: staff
   Mengubah data user: Ahmad Hidayat (ahmad@example.com)
   Menghapus user: Siti Nurhaliza (siti@example.com)
   ```

6. **Login/Logout**
   ```
   Login: Admin User (admin@example.com)
   Logout: Admin User (admin@example.com)
   ```

## Akses Log untuk Auditor

Auditor dapat melihat semua activity logs melalui:
- **Route**: `/logs` (dengan middleware `role:auditor,super_admin`)
- **Controller**: `LogController@index`
- **View**: `logs.index`

## Keamanan & Best Practice

1. **Automatic Logging** - Semua logging dilakukan otomatis via helper
2. **User Identification** - Setiap log mencatat ID dan nama user yang melakukan aksi
3. **Timestamp** - Setiap log memiliki timestamp otomatis (created_at)
4. **Role-Based** - Hanya auditor dan super_admin yang bisa melihat logs
5. **Non-Destructive** - Log bersifat append-only (tidak bisa diubah/dihapus)

## Masa Depan - Perluasan

Sistem ini dapat diperluas dengan:
1. Logging untuk operasi batch
2. IP address tracking (sudah ada di login_histories)
3. Change history detail (before/after values)
4. Email notification untuk aktivitas kritis
5. Export logs ke format CSV/Excel
