<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ApplicantListService;
use App\Services\ApplicantService;
use App\Http\Requests\StoreApplicantList;
use App\Http\Requests\CreateApplicantList;
use Facades\App\Repositories\ApplicantListRepository;
use App\Repositories\EventRepository;

class ApplicantListsController extends Controller
{
    private ApplicantListService $applicantListService;
    private EventRepository $eventRepository;
    private ApplicantService $applicantService;

    public function __construct(
        ApplicantListService $applicantListService,
        EventRepository $eventRepository,
        ApplicantService $applicantService
    )
    {
        $this->applicantListService = $applicantListService;
        $this->eventRepository = $eventRepository;
        $this->applicantService = $applicantService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateApplicantList $request)
    {
        $attributes = $request->validated();

        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('events.show', [
                'event' => $attributes['event']
            ])->with('notice', 'You dont have permission to change this event');  
        }

        return view(
            'applicant_lists.create',
            [
                'user' => Auth::user(),
                'slot' => $attributes['slot'],
                'event' => $attributes['event'],
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreApplicantList $request)
    {
        $attributes = $request->validated();

        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('events.show', [
                'event' => $attributes['event_id']
            ])->with('notice', 'You dont have permission to change this event');  
        }

        if (! $this->applicantListService->tryCreateApplicantList($attributes)) {
            $message = 'The list was not created because you don\'t have enough places left in the slot';
        } else {
            $message = 'A new list was created';
        }

        return redirect()->route('events.show',
            [
                'slot' => $attributes['slot_id'],
                'event' => $attributes['event_id'],
            ]
        )->with('notice', $message);
    }

    public function show(Request $request, int $id)
    {
        $user = Auth::user();
        $isOnList = false;

        $attribute = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);
        $event = $this->eventRepository->find($attribute['event']);
        
        if (isset($user->customer)) {
            $isOnList = $this->applicantService->isCustomerOnList($user->customer->id, $list->id);
        }

        return view('applicant_lists.show', [
                'list' => $list, 
                'event' => $event, 
                'user' => $user,
                'isOnList' => $isOnList,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Request $request, int $id)
    {
        $event = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);

        return view('applicant_lists.edit', [
            'list' => $list, 
            'event' => $event['event'], 
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, int $id)
    {
        $attributes = $request->validate([
            'slot_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'max_applicants' => 'required|integer|min:1',
        ]);

        $list = ApplicantListRepository::update($attributes, $id);
        $event = $this->eventRepository->find($request->event);

        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('applicant_lists.show', [
                'list' => $list, 'event' => $event
            ])->with('notice', 'You dont have permission to change this event');  
        }

        return redirect()->route('events.show', [
            'event' => $event, 'user' => Auth::user()
        ])->with('status', 'Applicant list updated');
    }

    /**
     * Soft delete the specified list.
     *
     * @param  int  $id
     */
    public function destroy(Request $request, int $id)
    {
        $attributes = $request->validate([
            'event' => 'required|integer',
        ]);

        $list = ApplicantListRepository::find($id);
        $event = $this->eventRepository->find($attributes['event']);
        $url = route('cancel.list', ['list' => $list, 'event' => $event]);

        // Authorise user action
        $user = Auth::user();


        if ($this->applicantListService->hasApplicants($id)) {
            
            return redirect()->route('applicant_lists.show', [
                $list, 'event' => $event
            ])
                ->with(
                    'cancel',
                    'Applicants will be automatically notified of the cancellation! 
                    <a href="'. $url .'">Confirm cancellation</a>'
            );
        }

        if (ApplicantListRepository::softDelete($id)) {
            $message = "($list->name) list canceled";
        } else {
            $message = "Oops!! something went wrong. The ($list->name) list could not be canceled, please notify customer service";
        }

        return redirect()->route('events.show', $event)->with('message', $message);
    }
}
