@extends('layouts.app')

@section('title', 'Add slot')

@section('content')

<form action="{{ route('slots.store', ['event_id' => $event]) }}" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" value="">
        <label for="">Capacity</label>
        <input type="number" name="slot_capacity" value="">
        <label for="">Start Date</label>
        <input type="date" name="start_date" value="">
        <label for="">End Date</label>
        <input type="date" name="end_date" value="">
        <br>
        <input type="submit" value="submit">
    <br>
    <a href="{{ route('events.show', ['event' => $event]) }}">Back to event</a>
</form>
@endsection()