<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventOganiser;
use Facades\App\Repositories\EventOrganiserRepository;
use Illuminate\Http\Request;

class EventOrganisersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisers = EventOrganiserRepository::all();

        return view('event_organisers.index', ['organisers' => $organisers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event_organisers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventOganiser $request)
    {
        $attributes = $request->validated();
        $eventOrganiser = EventOrganiserRepository::create($attributes);

        return view('event_orgainsers.show', ['eventOrgainser' => $eventOrganiser]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organiser = EventOrganiserRepository::find($id);

        return view('event_organisers.show', ['organiser' => $organiser]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
