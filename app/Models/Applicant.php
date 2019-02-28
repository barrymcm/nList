<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    protected $attributes = ['email'];
    protected $fillable = ['user_id', 'first_name', 'last_name', 'dob', 'gender', 'email'];
    protected $dates = ['deleted_at'];

    public function applicantList()
    {
        return $this->belongsToMany(ApplicantList::class);
    }

    public function contactDetails()
    {
        return $this->hasOne(ApplicantContactDetails::class);
    }

    public function getEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
    }
}
