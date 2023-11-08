<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Billing extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'billing_id', 'id');
    }

    public function billingDetails()
    {
        return $this->hasMany(BillingDetails::class, 'billing_id');
    }


}




