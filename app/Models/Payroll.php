<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransportationDetails;
use App\Models\Employee;

class Payroll extends Model
{
    use HasFactory;

    // Define the fields that are fillable
    protected $fillable = [
        'employee_id',
        'total_rate',
        'total_deduction',
        'total_net_salary',
        'status',
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetails::class);
    }
}
