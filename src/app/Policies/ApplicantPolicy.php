<?php

namespace App\Policies;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any applicants.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function view(User $user, Applicant $applicant)
    {
        return $applicant->customer->user->is($user);
    }

    /**
     * Determine whether the user can create applicants.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $applicant->customer->user->is($user);
    }

    /**
     * Determine whether the user can update the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function update(User $user, Applicant $applicant)
    {
        //
    }

    /**
     * Determine whether the user can delete the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function delete(User $user, Applicant $applicant)
    {   
        return $user->customer->id != $applicant->customer_id ? true : false;
    }

    /**
     * Determine whether the user can restore the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function restore(User $user, Applicant $applicant)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function forceDelete(User $user, Applicant $applicant)
    {
        //
    }
}
