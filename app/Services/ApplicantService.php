<?php


namespace App\Services;

use App\Repositories\ApplicantRepository;
use Facades\App\Repositories\ApplicantListRepository;

class ApplicantService
{
    private $applicantRepository;

    public function __construct(ApplicantRepository $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function tryAddApplicantToList($attributes)
    {
        $applicant = $this->assignAttributes($attributes);
        $listId = $applicant['list_id'];

        if (!$this->isListFull($listId)) {
            return $this->applicantRepository->store($applicant);
        }

        return false;

    }

    private function assignAttributes($attributes) : array
    {
        return [
            'list_id' => (int) $attributes['list_id'],
            'first_name' => (string) $attributes['first_name'],
            'last_name' => (string) $attributes['last_name'],
            'dob' => (string) $attributes['dob'],
            'gender' => (string) $attributes['gender']
        ];
    }

    /** @todo create a test */
    public function isListFull(int $listId) : bool
    {
        $applicants = $this->applicantRepository->getApplicantList($listId);
        $list = ApplicantListRepository::show($listId);

        if ($applicants->count() == $list->max_applicants) {

           return true;
        }

        return false;
    }
}