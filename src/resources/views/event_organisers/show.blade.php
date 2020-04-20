@extends('layouts.app')

@section('title', 'Event Organiser')

@section('content')
    <p>Add a new event <a href="{{ route('events.create', ['eventOrganiser' => $eventOrganiser]) }}">here!</a></p>
    <ul>
        <li><h3>{{ $eventOrganiser->name }}</h3></li>
        <li>{{ $eventOrganiser->description }}</li>
        <br/>
        <li>Events:</li>
        <ol>
            @foreach($eventOrganiser->events as $event)
                <li>
                    <a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a>
                </li>
            @endforeach
        </ol>
    </ul>

    <a href="{{ route('event_organisers.index') }}">Back</a>

@endsection