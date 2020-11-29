<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token'];
    
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function applicant()
    {
        return $this->hasOne(Applicant::class);
    }

    public function eventOrganiser()
    {
        return $this->hasOne(EventOrganiser::class);
    }

    public function role()
    {
        return $this->hasOne(UserRole::class);
    }
}
