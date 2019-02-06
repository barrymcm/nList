<?php

namespace App\Repositories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ApplicantRepository implements RepositoryInterface
{
    private $applicantModel;

    public function __construct(Applicant $applicantModel)
    {
        $this->applicantModel = $applicantModel;
    }

    public function all()
    {
        try {
            return $this->applicantModel::all();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->applicantModel::find($id);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function create(array $applicant)
    {
        return $this->applicantModel::create($applicant);
    }

    public function update(array $attributes, $id)
    {
        try {
            $applicant = $this->applicantModel::find($id);

            $applicant->list_id = $attributes['list_id'];
            $applicant->first_name = $attributes['first_name'];
            $applicant->last_name = $attributes['last_name'];
            $applicant->dob = $attributes['dob'];
            $applicant->gender = $attributes['gender'];

            $applicant->save();

            return $applicant;

        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function softDelete(int $id)
    {
        try {
            return $this->applicantModel::destroy($id);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function hardDelete()
    {

    }

    public function getApplicantList($listId)
    {
        return Applicant::where('list_id', $listId);
    }

    public function getListCount($listId)
    {
        return $this->getApplicantList($listId)->count();
    }
}