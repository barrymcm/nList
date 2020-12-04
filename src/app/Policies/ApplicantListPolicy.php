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

    public function view(User $user)
    {
        $eventOrganiser = $user->eventOrganiser;
        
        return $eventOrganiser->user->is($user);
    }

    public function addMe(User $user) 
    {
        return $user->customer->applicant->is($user);
    }

    /**
     * Determine whether the user can create applicant lists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->eventOrganiser->is($user)
            ? Response::allow() 
            : Response::deny('User not allowed to create a list');
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
        $eventOrganiser = $user->eventOrganiser;
        
        return $eventOrganiser->user->is($user);
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
