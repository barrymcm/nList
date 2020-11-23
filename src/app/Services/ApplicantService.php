<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Applicant;
use App\Events\ApplicantAddedToList;
use Illuminate\Foundation\Auth\User;
use App\Repositories\UserRepository;
use App\Repositories\ApplicantRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ApplicantApplicantListRepository;
use Facades\App\Repositories\ApplicantListRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;

/**
 * Class ApplicantService
 * @package App\Services
 */
class ApplicantService
{
    private ApplicantRepository $applicantRepository;
    private CustomerRepository $customerRepository;
    private UserRepository $userRepository;
    private ApplicantApplicantListRepository $applicantApplicantListRepository;

    /**
     * ApplicantService constructor.
     * @param ApplicantRepository $applicantRepository
     */
    public function __construct(
        ApplicantRepository $applicantRepository,
        CustomerRepository $customerRepository,
        UserRepository $userRepository,
        ApplicantApplicantListRepository $applicantApplicantListRepository
    )
    {
        $this->applicantRepository = $applicantRepository;
        $this->customerRepository = $customerRepository;
        $this->userRepository = $userRepository;
        $this->applicantApplicantListRepository = $applicantApplicantListRepository;
    }

    /**
     * @param $attributes
     * @param User $user
     * @return bool|string
     */
    public function tryAddApplicantToList(array $attributes, User $user) : ?Applicant
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

    private function assignApplicantAttributes(array $attributes, User $user) : array
    {
        return [
            'user_id' => $user->id,
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'dob' => $attributes['dob'],
            'gender' => $attributes['gender'],
        ];
    }

    public function isListFull(int $listId) : bool
    {
        $listCount = $this->applicantRepository->getListCount($listId);
        $list = ApplicantListRepository::find($listId);

        if ($listCount == $list->max_applicants) {
            return true;
        }

        return false;
    }

    public function userAddedToListEvent(Applicant $applicant) : void
    {
        $user = $this->userRepository->findById($applicant->customer_id); 
        event(new ApplicantAddedToList($applicant, $user));
    }

    public function hasCustomerAccount(User $user) : bool
    {
        $userRoleId = $user->role->role_id;
        $role = Role::find($userRoleId);

        return ($role->name == 'customer')? true : false;
    }

    public function isCustomerOnList(int $customerId, int $listId) : bool
    {
        $applicant = $this->applicantRepository->findByCustomerAndListId($customerId, $listId);

        if ($applicant->count() > 0) {
            return true;
        }

        return false;
    }

    public function assignApplicantContactDetails(int $applicantId, array $attributes): array
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
