<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApplicantList;
use App\Http\Requests\StoreApplicantList;
use Facades\App\Repositories\ApplicantListRepository;
use App\Services\ApplicantListService;
use Illuminate\Http\Request;

class ApplicantListsController extends Controller
{
    private $applicantListService;

    public function __construct(ApplicantListService $applicantListService)
    {
        $this->applicantListService = $applicantListService;
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

        return view('applicant_lists.create', [
                'slot' => $attributes['slot'],
                'event' => $attributes['event']
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicantList $request)
    {
        $attributes = $request->validated();
        $this->applicantListService->tryCreateApplicantList($attributes);

        return redirect()->route(
            'events.show',
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
        $event = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);

        return view('applicant_lists.show', ['list' => $list, 'event' => $event['event']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $event = $request->validate(['event' => 'required|integer']);
        $list = ApplicantListRepository::find($id);

        return view('applicant_lists.edit', ['list' => $list, 'event' => $event['event']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'event_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'max_applicants' => 'required|integer|min:1'
        ]);

        $list = ApplicantListRepository::update($attributes, $id);

        return view('applicant_lists.show', [
                'event' => $attributes['event_id'],
                'list' => $list
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = $request->validate(['event' => 'required|integer']);
        ApplicantListRepository::softDelete($id);

        return redirect()->route('events.show', $event)->with(
            'status', 'Applicant list removed'
        );
    }
}
