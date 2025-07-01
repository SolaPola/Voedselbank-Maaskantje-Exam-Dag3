<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    protected $fillable = [
        'date_received',
        'date_delivered',
        'packaging_unit',
        'quantity',
        'comment',
        'isactive'
    ];

    protected $casts = [
        'date_received' => 'date',
        'date_delivered' => 'date',
        'isactive' => 'boolean',
        'dateadded' => 'datetime',
        'datechanged' => 'datetime',
    ];

    /**
     * Get the product per warehouses for the warehouse.
     */
    public function productPerWarehouses(): HasMany
    {
        return $this->hasMany(ProductPerWarehouse::class);
    }
}
