<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantList extends Model
{
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'list_id');
    }
}
