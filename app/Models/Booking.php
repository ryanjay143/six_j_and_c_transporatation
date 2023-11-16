<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TransportationDetails;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'pickUp_date',
        'origin',
        'transportation_date',
        'destination',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function transportation()
    {
        return $this->hasMany(TransportationDetails::class, 'booking_id','id');
    }
    public function transportationDetails()
    {
        return $this->hasMany(TransportationDetails::class);
    }
}
