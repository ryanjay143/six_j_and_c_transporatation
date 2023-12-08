<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\Truck;
use App\Models\Employee;

use App\Models\BillingDetails;

class TransportationDetails extends Model
{
    use HasFactory;

    protected $table = 'transportation_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'booking_id',
        'driver_id',
        'helper_id',
        'truck_id',
        'status',
        'p_status',
        'h_status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id',);
    }
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }
    public function billing()
    {
        return $this->hasOne(BillingDetails::class, 'transportation_id');
    }
    public function updatedTime()
    {
        return $this->hasMany(UpdatedTime::class, 't_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }
    public function helper()
    {
        return $this->belongsTo(Employee::class, 'helper_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function updatedTimes()
    {
        return $this->hasMany(UpdatedTime::class, 't_id');
    }
    public function formattedDeliveredDate()
    {
        return $this->updated_at->format('F d, Y'); 
    }

    

}