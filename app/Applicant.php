<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'dob', 'gender'];

    public function createApplicant($attributes)
    {
        return Applicant::create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'dob' => $attributes['dob'],
            'gender' => $attributes['gender'],
        ]);
    }

    public function updateApplicant(array $attributes)
    {
        $this->first_name = $attributes['first_name'];
        $this->last_name = $attributes['last_name'];
        $this->dob = $attributes['dob'];
        $this->gender = $attributes['gender'];

        return $this->save();
    }
}
