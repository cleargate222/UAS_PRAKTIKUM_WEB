<?php

namespace App\Observers;

use App\Models\Product;
use App\Helpers\AuditHelper;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Observer ini bersifat opsional, logging sudah dilakukan di controller
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Observer ini bersifat opsional, logging sudah dilakukan di controller
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Observer ini bersifat opsional, logging sudah dilakukan di controller
    }
}
