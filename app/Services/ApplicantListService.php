<?php


namespace App\Services;


use App\Models\Applicant;
use App\Models\ApplicantList;

class ApplicantListService
{
    private $applicantListModel;

    public function __construct(ApplicantList $applicantList)
    {
        $this->applicantListModel = $applicantList;
    }

    public function getListOfApplicants($id)
    {
        return ApplicantList::find($id);
    }

    public function availablePlaces($id)
    {

    }
}