<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'dob', 'gender'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactDetails()
    {
        return $this->hasOne(ApplicantContactDetails::class);
    }

    public function applicantList()
    {
        return $this->belongsToMany(ApplicantList::class);
    }
}
