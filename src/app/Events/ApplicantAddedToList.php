<?php

namespace App\Events;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class ApplicantAddedToList
{
    use InteractsWithSockets, SerializesModels;

    public $applicant;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Applicant $applicant, User $user)
    {
        $this->applicant = $applicant;
        $this->user = $user;
    }
}
