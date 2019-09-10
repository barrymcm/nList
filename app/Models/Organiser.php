<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organiser extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'user_id', 'description'];
    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
