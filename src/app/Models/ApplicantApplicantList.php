<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantApplicantList extends Model
{
    protected $table = 'applicant_applicant_list';

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function applicantLists()
    {
        return $this->hasMany(ApplicantList::class);
    }
}
