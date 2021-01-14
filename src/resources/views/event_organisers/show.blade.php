@extends('layouts.app')

@section('title', 'Events')

@section('content')

    @can('create', $eventOrganiser)
    <div class="flex flex-row-reverse mb-10">
        <a class="w-1/6 bg-green-400 text-white text-center rounded-md h-10 px-4 py-2 hover:bg-green-500 transition-ease-in-out duration-150" href="{{ route('events.create', ['organiser' => $eventOrganiser->id]) }}">
            Create new Event!
        </a>
    </div>
    @endcan

    <div class="grid grid-rows-{{ count($eventOrganiser->events) }} grid-flow-row grid-cols-2 gap-6 text-center">
        @foreach($eventOrganiser->events as $event)
            <a class="my-3 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin py-2 cursor-pointer w-full" href="{{ route('events.show', $event->id) }}">
                {{ $event->name }}
            </a>
        @endforeach
    </div>

    <div class="flex text-blue-700 mt-10">
        <a class="flex items-center pb-3" href="{{ route('event_organisers.index') }}">
            <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
            <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
            </svg> 
        Back</a>
    </div>

@endsection