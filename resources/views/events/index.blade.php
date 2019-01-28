@extends('layouts.app')

@section('title', 'List of events')

@section('content')

    @foreach($events as $event)
        <ul>
            <li>{{ $event->name }}</li>
            <li><a href="{{ route('events.show', $event->id) }}">View event details</a></li>
        </ul>
    @endforeach
    <a href="{{ route('events.create') }}">Create new event</a>
@endsection