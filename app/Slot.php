<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['event_id', 'name', 'slot_capacity', 'start_date', 'end_date', 'created_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function applicantLists()
    {
        return $this->hasMany(ApplicantList::class);
    }
}
