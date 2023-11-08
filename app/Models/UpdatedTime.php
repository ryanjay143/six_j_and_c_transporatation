<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdatedTime extends Model
{
    use HasFactory;

    public function transportationDetails()
    {
        return $this->belongsTo(TransportationDetails::class, 't_id');
    }
}
