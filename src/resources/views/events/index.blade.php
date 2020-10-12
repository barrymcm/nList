@extends('layouts.app')

@section('title', 'List of events')

@section('content')
    @foreach($events as $event)
        <ul>
            <li>Organiser: {{ $event['organiser']['name'] }}</li>
            <li>Category: {{ $event->category->name }}</li>
            <li>Event: {{ $event->name }}</li>
            <li>
                <a href="{{ route('events.show', $event->id) }}">View event details</a>
            </li>
        </ul>
    @endforeach
    
    <br><br>

    @if (isset($user->eventOrganiser))
        <a href="{{ route('events.create', ['organiser' => $user->eventOrganiser->id]) }}">Create new event</a>
    @endif

@endsection