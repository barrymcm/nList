<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Http\Requests\StoreApplicant;

class ApplicantsController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applicants.create', [
            'list' => request('list'),
            'event' => request('event')
        ]);
    }

    /**
     * Store a newly cre\ated resource in storage.
     *
     * @param StoreApplicant $request
     * @param Applicant $applicant
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicant $request, Applicant $applicant)
    {
        $attributes = $request->validated();
        $newApplicant = $applicant->createApplicant($attributes);

        return redirect(route('applicants.show', ['applicant' => $newApplicant]));
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

        return view('applicants.edit', [
            'applicant' => $applicant,
            'list_id' => request('list')
        ]);
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
