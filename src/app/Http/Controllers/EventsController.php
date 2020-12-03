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

    public function index()
    {
        $user = null;

        if (Auth::check()) {
            $user = Auth::user();
        }

        $events = EventRepositoryFacade::all();

        return view('events.index', ['events' => $events, 'user' => $user]);
    }

    public function create(Request $request)
    {
        $attributes = $request->validate(['organiser' => 'required|integer']);
        $categories = Category::all();
        $user = Auth::user();

        return view('events.create', [
            'categories' => $categories,
            'eventOrganiser' => $user->eventOrganiser,
            'user' => $user,
        ]);
    }

    public function store(StoreEvent $request)
    {
        $user = Auth::user();
        $attributes = $request->validated();
        $attributes['event_organiser_id'] = $user->eventOrganiser->id;
        $event = $this->eventRepository->create($attributes);
        
        return redirect()->route('events.show', ['event' => $event, 'user' => $user]);
    }

    public function show(int $id)
    {
        $user = null;

        if (Auth::check()) {
            $user = Auth::user();
        }

        $event = EventService::find($id);

        return view('events.show', ['event' => $event, 'user' => $user]);
    }

    public function edit(Event $event)
    {
        $categories = Category::all();

        return view('events.edit', [
            'event' => $event, 
            'categories' => $categories->all(),
            'eventOrganiser' => Auth::user()->eventOrganiser,
        ]);
    }

    public function update(UpdateEvent $request, $id)
    {
        $attributes = $request->validated();
        $event = EventRepositoryFacade::update($attributes, $id);

        return redirect()->route('events.show', ['event' => $event, 'user' => Auth::user()])
            ->with('notice', 'Event details updated');
    }

    public function destroy(Request $request, $id)
    {
        $event = EventService::find($id);

        return view('events.show', ['event' => $event, 'user' => Auth::user()])
            ->with('message', 'Delete does not work yet!! duh .. :)');  
    }
}
