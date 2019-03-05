<?php

namespace App\Events;

use App\Models\Applicant;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ApplicantAddedToList
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $applicant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }
}
