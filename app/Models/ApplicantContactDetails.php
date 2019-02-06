<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantContactDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'applicant_id', 'email', 'phone', 'address_1',
        'address_2', 'address_3', 'city', 'post_code', 'country'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
