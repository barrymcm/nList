<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantContactDetails extends Model
{
    use SoftDeletes;

    protected $fillable = ['applicant_id', 'email', 'phone', 'address_1',
        'address_2', 'address_3', 'city', 'county', 'post_code', 'country'
    ];

    protected $dates = ['deleted_at'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
