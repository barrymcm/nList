<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ApplicantList
 * @package App\Models
 */
class ApplicantList extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['slot_id', 'name', 'max_applicants'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applicants()
    {
        return $this->belongsToMany(Applicant::class);
    }
}
