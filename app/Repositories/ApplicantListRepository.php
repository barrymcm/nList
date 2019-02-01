<?php


namespace App\Repositories;

use App\Models\ApplicantList;

class ApplicantListRepository implements RepositoryInterface
{
    private $applicantListModel;

    public function __construct(ApplicantList $applicantListModel)
    {
        $this->applicantListModel = $applicantListModel;
    }

    public function index()
    {
        return $this->applicantListModel::all();
    }

    public function show($id)
    {
        return $this->applicantListModel::find($id);
    }

    public function store(array $applicantList)
    {
        return $this->applicantListModel::create($applicantList);
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

}