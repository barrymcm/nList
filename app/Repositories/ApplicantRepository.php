<?php

namespace App\Repositories;

use App\Models\Applicant;
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
        return $this->applicantModel::all();
    }

    public function find($id)
    {

    }

    public function create(array $applicant)
    {
        return $this->applicantModel::create($applicant);
    }

    public function update(array $applicant)
    {

    }

    public function softDelete($id)
    {

    }

    public function hardDelete()
    {

    }

    public function getApplicantList($listId)
    {
        return DB::table('applicants')
            ->select(DB::raw('*'))
            ->where('list_id', $listId)
            ->get();
    }
}