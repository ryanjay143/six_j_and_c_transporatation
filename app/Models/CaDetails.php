<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaDetails extends Model
{
    use HasFactory;

    public function cashAdvance()
    {
        return $this->belongsTo(CashAdvance::class);
    }
    
}
