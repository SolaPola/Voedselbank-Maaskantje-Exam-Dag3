<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPerWarehouse extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'location',
        'comment',
        'isactive'
    ];

    protected $casts = [
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    /**
     * Get the product that owns the product per warehouse.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the warehouse that owns the product per warehouse.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
