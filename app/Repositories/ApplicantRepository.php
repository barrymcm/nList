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

    public function index()
    {
        return $this->applicantModel::all();
    }

    public function show($id)
    {

    }

    public function store(array $applicant)
    {
        return $this->applicantModel::create($applicant);
    }

    public function update()
    {

    }

    public function softDelete()
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