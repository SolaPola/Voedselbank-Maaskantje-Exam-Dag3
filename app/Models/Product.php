<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'allergy_type',
        'barcode',
        'expiry_date',
        'description',
        'status',
        'comment',
        'isactive'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product per warehouses for the product.
     */
    public function productPerWarehouses(): HasMany
    {
        return $this->hasMany(ProductPerWarehouse::class);
    }
}
