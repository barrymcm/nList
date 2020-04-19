<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_organiser_id',
        'description',
        'category_id',
        'total_slots',
    ];

    protected $dates = ['deleted_at'];

    public function organiser()
    {
        return $this->belongsTo(EventOrganiser::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
}
