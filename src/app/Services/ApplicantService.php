<?php

namespace App\Services;

use App\Models\Role;
use App\Events\ApplicantAddedToList;
use Illuminate\Foundation\Auth\User;
use App\Repositories\ApplicantRepository;
use App\Repositories\CustomerRepository;
use Facades\App\Repositories\ApplicantListRepository;
use Facades\App\Repositories\ApplicantApplicantListRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;

/**
 * Class ApplicantService
 * @package App\Services
 */
class ApplicantService
{
    private ApplicantRepository $applicantRepository;

    private CustomerRepository $customerRepository;

    /**
     * ApplicantService constructor.
     * @param ApplicantRepository $applicantRepository
     */
    public function __construct(
        ApplicantRepository $applicantRepository,
        CustomerRepository $customerRepository
    )
    {
        $this->applicantRepository = $applicantRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $attributes
     * @param User $user
     * @return bool|string
     */
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
     * @param $attributes
     * @param User $user
     * @return array
     */
    private function assignApplicantAttributes($attributes, User $user) : array
    {
        return [
            'user_id' => $user->id,
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'dob' => $attributes['dob'],
            'gender' => $attributes['gender'],
        ];
    }

    /**
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
     * @param $applicant
     */
    public function userAddedToListEvent($applicant)
    {
        event(new ApplicantAddedToList($applicant));
    }

    /**
     * @param $user
     * @return bool
     */
    public function hasCustomerAccount($user) : bool
    {
        $userRoleId = $user->role->role_id;
        $role = Role::find($userRoleId);

        return ($role->name == 'customer')? true : false;
    }

    public function isCustomerOnList(int $customerId, int $listId) : bool
    {
        $customer = $this->customerRepository->find($customerId);
       
        if (!$customer->id) {
            return false;
        }

        $applicant = $this->applicantRepository->findByCustomerId($customer->id);
  
        if (!$applicant->contains($customer->id)) {
            return false;
        }

        $applicantList = ApplicantApplicantListRepository::findBy($listId, $applicantIds);

        return ($applicantList)? true : false;
    }

    /**
     * @param $applicantId
     * @param $attributes
     * @return array
     */
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
            'country' => $attributes['country'],
        ];
    }
}
