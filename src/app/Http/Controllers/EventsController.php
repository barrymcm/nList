<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use Facades\App\Services\EventService;
use Facades\App\Repositories\EventRepository as EventRepositoryFacade;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
        }

        $events = EventRepositoryFacade::all();

        return view('events.index', ['events' => $events, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $attributes = $request->validate(['organiser' => 'required|integer']);
        $categories = Category::all();

        return view('events.create', [
            'categories' => $categories,
            'event_organiser_id' => $attributes['organiser']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvent $request)
    {
        $attributes = $request->validated();
        $event = $this->eventRepository->create($attributes);
        
        return view('events.show', ['event' => $event]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            $user = Auth::user();    
        }
        
        $event = EventService::find($id);

        return view('events.show', ['event' => $event, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $categories = Category::all();

        return view('events.edit', [
            'event' => $event, 
            'categories' => $categories->all()
        ]);
    }

    /**
     * Update the specified resource in storage.s
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEvent $request, $id)
    {
        $attributes = $request->validated();
        $event = EventRepositoryFacade::update($attributes, $id);

        return view('events.show', ['event' => $event]);
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
