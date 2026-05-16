<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['product_id', 'user_id', 'type', 'quantity', 'note'];

    // Hubungkan transaksi dengan produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hubungkan transaksi dengan user yang melakukan transaksi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
