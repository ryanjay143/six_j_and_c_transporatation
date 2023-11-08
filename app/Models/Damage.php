<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    use HasFactory;

    public function damageDetails()
    {
        return $this->hasMany(DamageDetails::class, 'd_id'); 
    }
}
