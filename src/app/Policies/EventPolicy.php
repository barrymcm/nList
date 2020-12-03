<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Models\EventOrganiser;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function create(User $user, EventOrganiser $eventOrganiser)
    {
        return $eventOrganiser->user->is($user);
    }

    public function update(User $user, Event $event)
    {
        if (isset($user->customer)) {
            return false;
        }

        return $user->eventOrganiser->id === $event->event_organiser_id;
    }

    public function delete(User $user, Event $event)
    {
        if (isset($user->customer)) {
            return false;
        }

        return $user->eventOrganiser->id === $event->event_organiser_id;
    }

    public function restore(User $user, Event $event)
    {
        //
    }

    public function forceDelete(User $user, Event $event)
    {
        //
    }
}
