<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfile;
use App\Repositories\ApplicantRepository;
use App\Services\ApplicantService;
use Facades\App\Repositories\ApplicantContactDetailsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class UsersProfileController extends Controller
{

    private $applicantRepository;
    private $applicantService;

    public function __construct(ApplicantService $applicantService, ApplicantRepository $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
        $this->applicantService = $applicantService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('users profile index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users_profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request, User $user)
    {
        // Need to store a new user profile using exising ApplicantRepository

        $attributes = $request->validated();

        $applicantProfileAttributes = $this->applicantService->assignApplicantAttributes($attributes, $user);
        $this->applicantRepository->create($applicantProfileAttributes);

        $contactDetails = ApplicantContactDetailsRepository::create($attributes);

        return redirect()->route('users_profile.show', ['id' => $contactDetails->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
