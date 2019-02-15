@extends('layouts.app')

@section('title', 'Event Orgainser')

@section('content')

    <ul>
        <li>Name: {{ $eventOrgainser->name }}</li>
        <li>Description: {{ $eventOrgainser->description }}</li>
        <li>
            <a href="#">Events</a>
        </li>
    </ul>

@endsection