<?php


namespace App\Services;

use App\Events\ApplicantAddedToList;
use App\Models\Role;
use Facades\App\Repositories\ApplicantApplicantListRepository;
use Illuminate\Foundation\Auth\User;
use App\Repositories\ApplicantRepository;
use Facades\App\Repositories\ApplicantListRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;

/**
 * Class ApplicantService
 * @package App\Services
 */
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

    /**
     * @param $applicant
     */
    public function userAddedToListEvent($applicant)
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

    /**
     *
     * @param int $listId
     * @return bool
     */
    public function isListFull(int $listId) : bool
    {
        $listCount = $this->applicantRepository->getListCount($listId);
        $list = ApplicantListRepository::find($listId);

        if ($listCount == $list->max_applicants) {

            return true;
        }

        return false;
    }

    /**
     *
     * @param $user
     * @return bool
     */
    public function isUserCustomer($user) : bool
    {
        $userRoleId = $user->role->role_id;
        $role = Role::find($userRoleId);

        return ($role->name == 'customer')? true : false;
    }

    public function isUserOnList($userId, $listId) : bool
    {
        $applicant = $this->applicantRepository->findByUserId($userId);
        $applicantIds = $applicant->pluck('id');
        $applicantList = ApplicantApplicantListRepository::findBy($listId, $applicantIds);

        return ($applicantList)? true : false;
    }

    public function assignApplicantContactDetails($applicantId, $attributes): array
    {
        return [
            'applicant_id' => $applicantId,
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