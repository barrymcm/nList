<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventOrganiser extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description'];
    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
