<?php


namespace App\Services;

use Facades\App\Repositories\ApplicantContactDetailsRepository;
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
        $applicantAttributes = $this->assignApplicantAttributes($attributes);

        if (!$this->isListFull($applicantAttributes['list_id'])) {

            $applicant = $this->applicantRepository->create($applicantAttributes);
            $contactDetails = $this->assignApplicantContactDetails($applicant->id, $attributes);
            ApplicantContactDetailsRepository::create($contactDetails);

            return $applicant;
        }

        return false;

    }

    private function assignApplicantAttributes($attributes) : array
    {
        return [
            'list_id' => $attributes['list_id'],
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'dob' => $attributes['dob'],
            'gender' => $attributes['gender']
        ];
    }

    private function assignApplicantContactDetails($id, $attributes) : array
    {
        return [
            'applicant_id' => $id,
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'address_1' => $attributes['address_1'],
            'address_2' => $attributes['address_2'],
            'address_3' => $attributes['address_3'],
            'county' => $attributes['county'],
            'city' => $attributes['city'],
            'post_code' => $attributes['post_code'],
            'country' => $attributes['country']
        ];
    }

    /** @todo create a test */
    public function isListFull(int $listId) : bool
    {
        $listCount = $this->applicantRepository->getListCount($listId);
        $list = ApplicantListRepository::find($listId);

        if ($listCount == $list->max_applicants) {

           return true;
        }

        return false;
    }
}