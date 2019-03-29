<?php


namespace App\Services;

use App\Events\ApplicantAddedToList;
use Illuminate\Foundation\Auth\User;
use App\Repositories\ApplicantRepository;
use Facades\App\Repositories\ApplicantListRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;

class ApplicantService
{
    private $applicantRepository;

    public function __construct(ApplicantRepository $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function tryAddApplicantToList($attributes, User $user)
    {
        $applicantAttributes = $this->assignApplicantAttributes($attributes, $user);
        $listId = $attributes['list'];

        if (! $this->isListFull($listId)) {
            $applicant = $this->applicantRepository->create($applicantAttributes, $listId);
            $contactDetails = $this->assignApplicantContactDetails($applicant->id, $attributes);
            ApplicantContactDetailsRepository::create($contactDetails);

            return $applicant;
        }

        return false;

    }

    public function sendAddedToListNotification($applicant)
    {
        event(new ApplicantAddedToList($applicant));
    }

    public function assignApplicantAttributes($attributes, User $user) : array
    {
        return [
            'user_id' => $user->id,
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'dob' => $attributes['dob'],
            'gender' => $attributes['gender']
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

    public function assignApplicantContactDetails($id, $attributes) : array
    {
        return [
            'applicant_id' => $id,
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
}