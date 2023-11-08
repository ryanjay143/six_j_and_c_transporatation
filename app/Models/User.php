<?php
 
namespace App\Models;
 
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Employee;
use App\Models\Booking;
use App\Models\Billing;
 
use Illuminate\Database\Eloquent\Casts\Attribute;
 
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $primaryKey = 'id';
    protected $table = 'users';


    protected $fillable = [
        'name',
        'lname',
        'email',
        'username',
        'phone_num',
        'password',
        'type',
        'is_disabled'
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];
 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["user", "admin", "employee"][$value],
        );
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'user_id','id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id','id');
    }
    public function billings()
    {
        return $this->hasMany(Billing::class, 'user_id', 'id');
    }
    
}