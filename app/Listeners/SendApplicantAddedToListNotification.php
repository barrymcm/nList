<?php

namespace App\Listeners;

use App\Events\ApplicantAddedToList;
use App\Mail\AddedToList;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendApplicantAddedToListNotification
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
        Mail::to($event->applicant->user->email)
            ->queue(new AddedToList($event->applicant));
    }
}
