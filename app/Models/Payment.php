<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }
    public function billingUser()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }


}
