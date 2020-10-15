<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ApplicantListService;
use App\Http\Requests\StoreApplicantList;
use App\Http\Requests\CreateApplicantList;
use Facades\App\Repositories\ApplicantListRepository;
use App\Repositories\EventRepository;

class ApplicantListsController extends Controller
{
    private ApplicantListService $applicantListService;
    private EventRepository $eventRepository;

    public function __construct(
        ApplicantListService $applicantListService,
        EventRepository $eventRepository
    )
    {
        $this->applicantListService = $applicantListService;
        $this->eventRepository = $eventRepository;
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

        if (Gate::denies('create', Auth::user())) {

            return view('applicant_lists.show', 
                [
                    'slot' => $attributes['slot_id'],
                    'event' => $attributes['event_id'],
                ]
            );
        }

        $this->applicantListService->tryCreateApplicantList($attributes);

        return redirect()->route('events.show',
            [
                'event' => $attributes['event_id'],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $attribute = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);
        $event = $this->eventRepository->find($attribute['event']);
        $user = Auth::user();

        return view('applicant_lists.show', ['list' => $list, 'event' => $event, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Request $request, $id)
    {
        $event = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);

        return view('applicant_lists.edit', 
            ['list' => $list, 'event' => $event['event']]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'slot_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'max_applicants' => 'required|integer|min:1',
        ]);

        $list = ApplicantListRepository::update($attributes, $id);
        $event = $this->eventRepository->find($request->event);

        return redirect()->route('events.show', $event)->with(
            'status',
            'Applicant list updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Request $request, $id)
    {
        $event = $request->validate(['event' => 'required|integer']);
        ApplicantListRepository::softDelete($id);

        return redirect()->route('events.show', $event)->with(
            'status',
            'Applicant list removed'
        );
    }
}
