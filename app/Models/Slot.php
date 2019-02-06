<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $guarded = ['created_at'];

    protected $dates = ['start_date', 'end_date', 'created_at'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function applicantLists()
    {
        return $this->hasMany(ApplicantList::class);
    }
}
