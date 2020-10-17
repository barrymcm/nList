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
        $user = null;

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

        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('events.show')->with('status', 'You do not have permission to create a new event');
        }

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
        if (!Auth::user()->eventOrganiser) {
            return redirect('login')->with('status', 'You are not logged in!');
        }

        $user = Auth::user();
        $attributes = $request->validated();
        $event = $this->eventRepository->create($attributes);
        
        return redirect()->route('events.show', [
            'event' => $event, 'user' => $user
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
        $user = null;

        if (Auth::check()) {
            $user = Auth::user();
        }

        $user = Auth::user();
        $event = EventService::find($id);

        return view('events.show', [
            'event' => $event, 'user' => $user
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('show.events', [$event])->with('status', 'You cannot update this event!');
        }

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
        if (!Auth::user()->eventOrganiser) {
            return redirect()->route('show.events', [$event])->with('status', 'You cannot update this event!');
        }

        $attributes = $request->validated();
        $event = EventRepositoryFacade::update($attributes, $id);

        return redirect()->route('events.show', [
            'event' => $event, 'user' => Auth::user()
        ])->with('notice', 'Event details updated');
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
