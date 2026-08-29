<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['name', 'email', 'username', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    // A user can place many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
