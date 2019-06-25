@extends('layouts.app')

@section('title', 'Create List')

@section('content')

    <form action="{{ route('applicant_lists.store', ['slot' => $slot, 'event' => $event]) }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event }}">
        <input type="hidden" name="slot_id" value="{{ $slot }}">

        <label for="name">List name:</label>
        <input type="text" name="name" value="">
        <label for="max_applicants">Max applicants</label>
        <input type="number" name="max_applicants" min="1">

        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('events.show', ['event' => $event]) }}">Back to event</a>

@endsection