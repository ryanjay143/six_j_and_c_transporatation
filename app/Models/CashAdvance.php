<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashAdvance extends Model
{
    use HasFactory;

    public function caDetails()
    {
        return $this->hasMany(CaDetails::class, 'ca_id'); 
    }

}
