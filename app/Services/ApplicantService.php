<?php


namespace App\Services;

use Facades\App\Repositories\ApplicantContactDetailsRepository;
use App\Repositories\ApplicantRepository;
use Facades\App\Repositories\ApplicantListRepository;
use Illuminate\Foundation\Auth\User;

class ApplicantService
{
    private $applicantRepository;

    public function __construct(ApplicantRepository $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function confirmApplicantsEmail()
    {
        // 2. Notification - Send a validate email confirmation to their inbox -> (add to a queue)

        // 3. When we receive confirmation then add them to the list and add their details to the DB
    }

    public function tryAddApplicantToList($attributes, User $user)
    {
        $applicantAttributes = $this->assignApplicantAttributes($attributes, $user);
        $listId = $attributes['list'];

        if (! $this->isListFull($listId)) {
            $applicant = $this->applicantRepository->create($applicantAttributes, $listId);
            $contactDetails = $this->assignApplicantContactDetails($applicant->id, $attributes);
            ApplicantContactDetailsRepository::create($contactDetails);

            // 4. Send them a confirmation mail to say they have been added to the list :
            // Scenarios :
            //              -> Added to list confirmation
            //              -> Pending status (Depends on event owners approval)
            //              -> Payment Received (Confirmation)

            return $applicant;
        }

        return false;

    }

    public function sendAddedToListNotification()
    {

    }

    private function assignApplicantAttributes($attributes, User $user) : array
    {
        return [
            'user_id' => $user->id,
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