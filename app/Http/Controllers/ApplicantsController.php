<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Http\Requests\StoreApplicant;
use App\Services\ApplicantService;


class ApplicantsController extends Controller
{
    private $applicantService;

    public function __construct(ApplicantService $applicantService)
    {
        $this->applicantService = $applicantService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicants = Applicant::all();

        return view('applicants.index', ['applicants' => $applicants]);
    }

    /**
     * @todo Refactor to remove the need for the if statment
     *
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->applicantService->isListFull(request('list'))) {

            return view(
                'applicants.create', [
                    'list' => (int)request('list'),
                    'event' => (int)request('event')
                ]
            );
        }

        return redirect(
            route(
                'applicant_lists.show', [
                    'list' => (int)request('list'),
                    'event' => (int)request('event')
                ]
            )
        );
    }

    /**
     * Store a newly cre\ated resource in storage.
     *
     * @param StoreApplicant $request
     * @param Applicant $applicant
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicant $request)
    {
        $event = (int) request('event_id');
        $list = (int) request('list_id');

        $attributes = $request->validated();
        $this->applicantService->tryAddApplicantToList($attributes);

        return redirect(
            route(
                'applicant_lists.show', [
                    'list' => $list,
                    'event' => $event
                ]
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applicant = Applicant::find($id);

        return view('applicants.show', ['applicant' => $applicant]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::find($id);

        return view(
            'applicants.edit', [
                'applicant' => $applicant,
                'list_id' => (int) request('list')
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreApplicant $request
     * @param Applicant $applicant
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreApplicant $request, $id)
    {
        $attributes = $request->validated();
        $applicant = Applicant::find($id);
        $applicant->updateApplicant($attributes);

        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Applicant::destroy($id);

        return redirect(route('applicants.index'));
    }
}
