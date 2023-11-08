<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportationDetails;

class PayrollDetails extends Model
{
    use HasFactory;

    public function transportation()
    {
        return $this->belongsTo(TransportationDetails::class, 'transportation_id');
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }
}
