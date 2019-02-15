@extends('layouts.app')

@section('title', 'Event Organisers')

@section('content')

    <ul>
        @foreach($organisers as $organiser)
            <li>Name: {{ $organiser->name }}</li>
            <li>Description: {{ $organiser->description }}</li>
            <br/>
            <a href="{{ route('event_organisers.show', $organiser ) }}">View Events</a>
        @endforeach
    </ul>

@endsection