<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'stock', 'min_stock', 'description', 'supplier_id'];

    // Hubungkan produk dengan supplier (User)
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}
