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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
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

    /**
     * select `roles`.*, `user_role`.`user_id` as `laravel_through_key`
     *  from `roles`
     *  inner join `user_role` on `user_role`.`user_id` = `roles`.`user_role_id`
     * where `user_role`.`user_id` = 88
     * limit 1
     *
     * select `roles`.*, `user_role`.`user_id` as `laravel_through_key`
     *  from `roles` inner
     *  join `user_role` on `user_role`.`id` = `roles`.`user_role_id`
     * where `user_role`.`user_id` = 88
     * limit 1
     *
     */
}
