<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckInformation extends Model
{
    use HasFactory;

    
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id','id');
    }

}
