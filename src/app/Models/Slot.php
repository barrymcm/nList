<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public $attributes = ['availability'];
    protected $dates = ['start_date', 'end_date', 'created_at'];
    protected $fillable = [
        'event_id', 'name',
        'slot_capacity', 'total_lists',
        'start_date', 'end_date', 'availability',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function applicantLists()
    {
        return $this->hasMany(ApplicantList::class);
    }

    public function setAvailabilityAttribute($value)
    {
        return $this->attributes['availability'] = $value;
    }

    public function getAvailabilityAttribute()
    {
        return $this->attributes['availability'];
    }
}
