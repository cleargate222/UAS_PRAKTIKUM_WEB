<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'current_stock',
        'min_stock',
        'max_stock',
        'unit_price',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
        ];
    }

    /**
     * Get the transactions for the product.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Check if product is in critical stock (current_stock <= min_stock).
     */
    public function isCriticalStock(): bool
    {
        return $this->current_stock <= $this->min_stock;
    }

    /**
     * Get stock status label.
     */
    public function getStockStatusLabel(): string
    {
        if ($this->isCriticalStock()) {
            return 'KRITIS';
        }
        if ($this->current_stock >= $this->max_stock) {
            return 'PENUH';
        }
        return 'NORMAL';
    }

    /**
     * Scope: Get products with critical stock.
     */
    public function scopeCriticalStock($query)
    {
        return $query->whereRaw('current_stock <= min_stock');
    }

    /**
     * Scope: Get active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
