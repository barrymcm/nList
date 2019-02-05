<?php

namespace App\Http\Controllers;

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
    public function create(Request $request)
    {
        $slot = $request->get('slot');
        $event = $request->get('event');

        return view('applicant_lists.create', ['slot' => $slot, 'event' => $event]);
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
        $this->applicantListService->createApplicantList($attributes);

        return redirect()->route('events.show', ['event' => $attributes['event_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $list = ApplicantListRepository::find($id);

        return view(
            'applicant_lists.show',
            [
                'list' => $list,
                'event' => $request->get('event')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

        return redirect()->route('events.show', $event);
    }
}
