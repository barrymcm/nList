<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CancellationService;
use App\Repositories\EventRepository;
use App\Repositories\ApplicantListRepository;

class CancellationController extends Controller
{
	private CancellationService $cancellationService;
	private EventRepository $eventRepository;
	private ApplicantListRepository $applicantListRepository;

	public function __construct(
		CancellationService $cancellationService,
		EventRepository $eventRepository,
		ApplicantListRepository $applicantListRepository
	) 
	{
		$this->cancellationService = $cancellationService;
		$this->eventRepository = $eventRepository;
		$this->applicantListRepository = $applicantListRepository;
	}

    public function cancelList(Request $request)
    {
    	$attributes = $request->validate([
    		'list' => 'required|integer',
    		'event' => 'required|integer'
    	]);
    	
    	$event = $this->eventRepository->find($attributes['event']);
    	$list = $this->applicantListRepository->find($attributes['list']);
    	$isListCanceled = $this->applicantListRepository->softDelete($list->id);
    	$applicantsNotified = $this->cancellationService->notifyApplicants($list->id);

    	if ($isListCanceled && $applicantsNotified) {
            $message = "($list->name) list canceled, Applicants will be notified of the cancellation!";
        } else {
            $message = "Oops!! something went wrong. The ($list->name) list could not be canceled, please notify customer service";
        }

    	return redirect()->route('events.show', [
    		'event' => $event, 'user' => Auth::user()
    	])->with('message', $message);
    }

    public function cancelSlot()
    {

    }

    public function cancelEvent()
    {

    }
}
