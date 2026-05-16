<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    /**
     * Mencatat aktivitas ke database
     * @param string $activity - Deskripsi aktivitas yang dilakukan
     */
    public static function log($activity)
    {
        // Jika user belum login, skip logging
        if (!Auth::check()) {
            return;
        }

        // Simpan activity log ke database
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $activity,
        ]);
    }

    /**
     * Mencatat tindakan menambah produk
     */
    public static function logCreateProduct($product)
    {
        self::log("Menambah produk: {$product->name} (Stok: {$product->stock}, Min: {$product->min_stock})");
    }

    /**
     * Mencatat tindakan mengubah produk
     */
    public static function logUpdateProduct($product, $changes)
    {
        $changeDetails = [];

        if (isset($changes['name'])) {
            $changeDetails[] = "Nama: {$changes['name']}";
        }
        if (isset($changes['stock'])) {
            $changeDetails[] = "Stok: {$changes['stock']}";
        }
        if (isset($changes['min_stock'])) {
            $changeDetails[] = "Min Stok: {$changes['min_stock']}";
        }
        if (isset($changes['description'])) {
            $changeDetails[] = "Deskripsi diubah";
        }

        $changes_text = implode(", ", $changeDetails);
        self::log("Mengubah produk: {$product->name} ({$changes_text})");
    }

    /**
     * Mencatat tindakan menghapus produk
     */
    public static function logDeleteProduct($productName)
    {
        self::log("Menghapus produk: {$productName}");
    }

    /**
     * Mencatat tindakan transaksi stok
     */
    public static function logTransaction($productName, $type, $quantity, $note = null)
    {
        $typeLabel = $type === 'in' ? 'Stok Masuk' : 'Stok Keluar';
        $activity = "{$typeLabel}: {$productName} (Qty: {$quantity})";

        if (!empty($note)) {
            $activity .= " - Catatan: {$note}";
        }

        self::log($activity);
    }

    /**
     * Mencatat tindakan menambah user
     */
    public static function logCreateUser($user)
    {
        self::log("Menambah user: {$user->name} ({$user->email}) - Role: {$user->role}");
    }

    /**
     * Mencatat tindakan mengubah user
     */
    public static function logUpdateUser($user)
    {
        self::log("Mengubah data user: {$user->name} ({$user->email})");
    }

    /**
     * Mencatat tindakan menghapus user
     */
    public static function logDeleteUser($userName, $email)
    {
        self::log("Menghapus user: {$userName} ({$email})");
    }

    /**
     * Mencatat tindakan login
     */
    public static function logLogin($user)
    {
        self::log("Login: {$user->name} ({$user->email})");
    }

    /**
     * Mencatat tindakan logout
     */
    public static function logLogout($user)
    {
        self::log("Logout: {$user->name} ({$user->email})");
    }

    /**
     * Mencatat tindakan mengubah profil
     */
    public static function logUpdateProfile($userName)
    {
        self::log("Mengubah profil pribadi: {$userName}");
    }
}
