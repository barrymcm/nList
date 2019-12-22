<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSlot;
use App\Http\Requests\UpdateSlot;
use Facades\App\Repositories\SlotRepository;
use Facades\App\Repositories\EventRepository;

class SlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $event = $request->validate(['event' => 'required|integer']);

        return view('slots.create', $event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlot $request)
    {
        $attributes = $request->validated();
        SlotRepository::create($attributes);

        return redirect()->route('events.show', $attributes['event_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slot = SlotRepository::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $slot = SlotRepository::find($id);
        $event = $request->get('event');

        return view('slots.edit', ['slot' => $slot, 'event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlot $request, $id)
    {
        $attributes = $request->validated();
        $slot = SlotRepository::update($attributes, $id);
        $event = EventRepository::find($slot->event_id);

        return redirect()->route('events.show', ['event' => $event]);
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