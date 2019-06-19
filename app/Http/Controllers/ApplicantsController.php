<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Services\ApplicantService;
use Illuminate\Support\Facades\Auth;
use App\Events\ApplicantAddedToList;
use App\Http\Requests\StoreApplicant;
use Facades\App\Repositories\ApplicantRepository;
use Facades\App\Repositories\ApplicantContactDetailsRepository;

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
        $user = auth()->user();
        $list = (int) request('list');
        $event = (int) request('event');

        if (! auth()->check()) {
            return redirect()->route('applicant_lists.show', [
                    'list' => $list,
                    'event' => $event
                    ]
            )->with('warning', 'Whoops .. looks like your not logged in!');
        }

        if (! $user->email_verified_at) {
            return redirect()->route('verification.notice')
                ->with('warning', 'Oh! It looks like you still need to verify your account');
        }

        if ($this->applicantService->isListFull(request('list'))) {

            return redirect()->route('applicant_lists.show', [
                    'list' => $list,
                    'event' => $event
                ]
            )->with('warning', 'Uh oh... This list is already full!');
        }

        $isCustomer = $this->applicantService->isUserCustomer($user);

        if (auth()->check() && $isCustomer) {

            $isOnList = $this->applicantService->isUserOnList($user->customer->user_id, $list);

            if ($isOnList) {
                return redirect()->route('applicant_lists.show', [
                    'list' => $list,
                    'event' => $event
                ])->with('warning', 'It looks like your already on the list!' );
            }

            /**
             * @todo - should a user be able to add additional applicants to a list  ( GDPR )?
             * eg -  user may want to add 3 different people to a list.
             *
             */

            $attributes = [
                'user_id' =>  $user->customer->user_id,
                'first_name' => $user->customer->first_name,
                'last_name' => $user->customer->last_name,
                'dob' => $user->customer->dob,
                'gender' => $user->customer->gender
            ];

            $applicant = ApplicantRepository::create($attributes, $list);

            if ($applicant->id) {
                return redirect()->route('applicant_lists.show', [
                    'list' => $list,
                    'event' => $event
                ]);
            }
        }

        return view('applicants.create', ['list' => $list, 'event' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreApplicant $request
     * @param Applicant $applicant
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicant $request)
    {
        Auth::check();

        $attributes = $request->validated();
        $applicant = $this->applicantService->tryAddApplicantToList($attributes, Auth::user());

        event(new ApplicantAddedToList($applicant));

        return redirect()->route('applicant_lists.show', [
                'list' => $attributes['list'],
                'event' => $attributes['event']
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
        $list = (int) $request->get('list');
        $applicant = ApplicantRepository::find($id);

        return view('applicants.show', [
            'applicant' => $applicant,
            'event' => $event,
            'list' => $list
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $applicant = Applicant::find($id);
        $event = (int) $request->get('event');
        $list = (int) $request->get('list');

        return view(
            'applicants.edit', [
                'applicant' => $applicant,
                'event' => $event,
                'list' => $list
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

        return view('applicants.show', [
            'applicant' => $applicant,
            'list' => $attributes['list'],
            'event' => $attributes['event']
        ]);
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
