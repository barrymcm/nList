<?php

namespace App\Listeners;

use App\Mail\AddedToList;
use Illuminate\Support\Facades\Mail;
use App\Events\ApplicantAddedToList;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendApplicantAddedToListNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApplicantAddedToList  $event
     * @return void
     */
    public function handle(ApplicantAddedToList $event)
    {
        Mail::to($event->applicant->user->email)->send(new AddedToList($event->applicant));
    }
}
