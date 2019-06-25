<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantList extends Model
{
    use SoftDeletes;

    protected $fillable = ['slot_id', 'name', 'max_applicants'];
    protected $dates = ['deleted_at'];

    public function applicants()
    {
        return $this->belongsToMany(Applicant::class);
    }
}
