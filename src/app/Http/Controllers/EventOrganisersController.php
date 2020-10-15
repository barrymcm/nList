<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventOganiser;
use Facades\App\Repositories\EventOrganiserRepository;

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

        return view('event_organisers.index', [
            'organisers' => $organisers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::check();
        $userId = auth()->user()->eventOrganiser->user_id;
        $eventOrganiser = EventOrganiserRepository::findBy($userId);

        return view('event_organisers.create', [
            'eventOrganiser' => $eventOrganiser
        ]);
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

        return view('event_organisers.show', [
            'eventOrganiser' => $eventOrganiser
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $eventOrganiser = EventOrganiserRepository::find($id);

        if (Auth::check()) {
            $user = Auth::user();

            return view('event_organisers.show', [
                'eventOrganiser' => $eventOrganiser, 
                'user' => $user
            ]);
        }

        return view('event_organisers.show', [
            'eventOrganiser' => $eventOrganiser,
        ]);    
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
