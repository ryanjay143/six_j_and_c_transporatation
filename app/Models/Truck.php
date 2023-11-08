<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportationDetails;

class Truck extends Model
{
    use HasFactory;

    protected $table = 'trucks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'truck_type',
        'plate_number',
        'truck_image',
        'status'
    ];
    public function transportation()
    {
        return $this->hasMany(TransportationDetails::class, 'truck_id','id');
    }
  
    public function updatedTimes()
    {
        return $this->hasMany(UpdatedTime::class, 't_id');
    }
    
    public function truckInformation()
    {
        return $this->hasMany(TruckInformation::class, 'truck_id');
    }




}
