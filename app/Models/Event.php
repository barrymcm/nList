<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'total_slots',
        'event_organiser_id',
        'category_id',
        'name',
        'description'
    ];

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