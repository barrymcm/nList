@extends('layouts.app')

@section('title', 'Event Orgainser')

@section('content')

    <ul>
        <li><h3>{{ $organiser->name }}</h3></li>
        <li>{{ $organiser->description }}</li>
        <li>Events:</li>
        <ol>
            @foreach($organiser->events as $event)
                <li>
                    <a href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a>
                </li>
            @endforeach
        </ol>
    </ul>

    <a href="{{ route('event_organisers.index') }}">Back</a>

@endsection