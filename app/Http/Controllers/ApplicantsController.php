<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Http\Requests\StoreApplicant;
use App\Repositories\EventRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;
use Facades\App\Repositories\ApplicantRepository;
use App\Services\ApplicantService;
use Illuminate\Http\Request;


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
        $attributes = $request->validated();
        $this->applicantService->tryAddApplicantToList($attributes);

        return redirect()->action('ApplicantListsController@show',
            [
                'event' => $attributes['event_id'],
                'list' => $attributes['list_id'],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $event = (int) $request->get('event');
        $applicant = ApplicantRepository::find($id);

        return view('applicants.show', ['applicant' => $applicant, 'event' => $event]);
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
        $applicant = ApplicantRepository::update($attributes, $id);

        return view('applicants.show', ['applicant' => $applicant]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $list = $request->get('list_id');
        $event = $request->get('event');

        ApplicantRepository::softDelete($id);
        ApplicantContactDetailsRepository::softDelete($id);

        return redirect()
            ->action('ApplicantListsController@show', ['list' => $list, 'event' => $event])
            ->with('status', 'Applicant removed');
    }
}
