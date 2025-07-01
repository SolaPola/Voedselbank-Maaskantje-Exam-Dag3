<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function contactPerFamilies()
    {
        return $this->hasMany(ContactPerFamily::class);
    }
}
