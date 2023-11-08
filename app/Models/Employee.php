<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TransportationDetails;
use App\Models\PayrollDetails;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'dob',
        'address',
        'position',
        'photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetails::class, 'employee_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function transportationDetails()
    {
        return $this->hasMany(TransportationDetails::class, 'driver_id');
    }

    public function cashAdvances()
    {
        return $this->hasMany(CashAdvance::class, 'employee_id');
    }

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }
}
