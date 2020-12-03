<?php

namespace App\Policies;

use App\Models\EventOrganiser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventOrganiserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any event organisers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the event organiser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EventOrganiser  $eventOrganiser
     * @return mixed
     */
    public function view(User $user, EventOrganiser $eventOrganiser)
    {
        return $eventOrganiser->user->is($user);
    }

    /**
     * Determine whether the user can create event organisers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, EventOrganiser $eventOrganiser)
    {
        return $eventOrganiser->user->is($user);
    }

    /**
     * Determine whether the user can update the event organiser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EventOrganiser  $eventOrganiser
     * @return mixed
     */
    public function update(User $user, EventOrganiser $eventOrganiser)
    {
        //
    }

    /**
     * Determine whether the user can delete the event organiser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EventOrganiser  $eventOrganiser
     * @return mixed
     */
    public function delete(User $user, EventOrganiser $eventOrganiser)
    {
        //
    }

    /**
     * Determine whether the user can restore the event organiser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EventOrganiser  $eventOrganiser
     * @return mixed
     */
    public function restore(User $user, EventOrganiser $eventOrganiser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the event organiser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EventOrganiser  $eventOrganiser
     * @return mixed
     */
    public function forceDelete(User $user, EventOrganiser $eventOrganiser)
    {
        //
    }
}
