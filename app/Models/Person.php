<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'family_id',
        'first_name',
        'infix',
        'last_name',
        'date_of_birth',
        'person_type',
        'is_representative',
        'isactive'
    ];
}
