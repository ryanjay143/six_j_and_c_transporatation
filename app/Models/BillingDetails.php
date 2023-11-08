<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportationDetails;

class BillingDetails extends Model
{
    use HasFactory;

    public function transpo()
    {
        return $this->belongsTo(TransportationDetails::class, 'transportation_id','id');
    }
}
