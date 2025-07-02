<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'street',
        'house_number',
        'addition',
        'postal_code',
        'city',
        'email',
        'mobile'
    ];
}
