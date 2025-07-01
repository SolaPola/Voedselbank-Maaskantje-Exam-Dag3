<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // If your table name is not 'contacts', uncomment the next line
    // protected $table = 'contacts';

    // Fillable fields (adjust as needed)
    protected $fillable = [
        'straat',
        'huisnummer',
        'toevoeging',
        'postcode',
        'woonplaats',
        'email',
        'mobile',
    ];

    // Relationships
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'contact_per_suppliers', 'contact_id', 'supplier_id');
    }
}
