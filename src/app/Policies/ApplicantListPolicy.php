<?php

namespace App\Policies;

use App\Models\ApplicantList;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicantListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any applicant lists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the applicant list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Model\ApplicantList  $applicantList
     * @return mixed
     */
    public function view(User $user, ApplicantList $applicantList)
    {

    }

    /**
     * Determine whether the user can create applicant lists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Customer $customer)
    {

    }

    /**
     * Determine whether the user can update the applicant list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ApplicantList  $applicantList
     * @return mixed
     */
    public function update(User $user, ApplicantList $applicantList)
    {
        return $user->id === 151 
            ? Response::allow() 
            : Response::deny('User not allowed to update the list');
        // match the event organiser id from the user object and the event object
    }

    /**
     * Determine whether the user can delete the applicant list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ApplicantList  $applicantList
     * @return mixed
     */
    public function delete(User $user, ApplicantList $applicantList)
    {
        //
    }

    /**
     * Determine whether the user can restore the applicant list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ApplicantList  $applicantList
     * @return mixed
     */
    public function restore(User $user, ApplicantList $applicantList)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the applicant list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ApplicantList  $applicantList
     * @return mixed
     */
    public function forceDelete(User $user, ApplicantList $applicantList)
    {
        //
    }
}
