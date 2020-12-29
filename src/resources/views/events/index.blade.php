@extends('layouts.app')

@section('title', 'List of events')

@section('content')

<div class="grid grid-rows-{{ count($events) }} grid-flow-row grid-cols-4 gap-6">
    @foreach($events as $event)
    <div class="rounded-md p-5 border-2 border-grey-400 leading-loose">
        <ul>
            <li>Event: {{ $event->name }}</li>
            <li>Organiser: {{ $event['organiser']['name'] }}</li>
            <li>Category: {{ $event->category->name }}</li>
            <li class="flex justify-center my-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin">
                <a class="w-full text-center p-1" href="{{ route('events.show', $event->id) }}">View event details</a>
            </li>
        </ul>
    </div>
    @endforeach
</div>

@if (@isset($user->eventOrganiser))
    <div class="flex flex-col justify-end ml-auto mt-20 rounded-sm h-10 bg-green-400 hover:bg-green-500 transition ease-in-out duration-150 font-thin w-1/5 ">
        <a class="flex flex-col w-full text-center p-2 text-white" href="{{ route('events.create', ['organiser' => $user->eventOrganiser->id]) }}">Create new event</a>
    </div>
@endif

@endsection