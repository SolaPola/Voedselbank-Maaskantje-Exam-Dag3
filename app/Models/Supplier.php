<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // If your table name is not 'suppliers', uncomment the next line
    // protected $table = 'suppliers';

    // Fillable fields (adjust as needed)
    protected $fillable = [
        'name',
        'supplier_number',
        'supplier_type_id',
        // add other fields as needed
    ];

    // Relationships
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_per_suppliers', 'supplier_id', 'contact_id');
    }

    public function type()
    {
        return $this->belongsTo(SupplierType::class, 'supplier_type_id');
    }
}
