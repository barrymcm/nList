@extends('layouts.app')

@section('title', 'Event Slot')

@section('content')
    <form class="form form-group" action="{{ route('slots.update', $slot) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="event_id" value="{{ $slot->event_id }}">
        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ $slot->name }}">
        <label for="">Capacity</label>
        <input type="number" name="slot_capacity" value="{{ $slot->slot_capacity }}">
        <label for="">Add lists</label>
        <input type="number" name="total_lists" value="{{ $slot->total_lists }}">
        <label for="">Start Date</label>
        <input type="date" name="start_date" value="{{ $slot->start_date }}">
        <label for="">End Date</label>
        <input type="date" name="end_date" value="{{ $slot->end_date }}">
        <label for="">Lists</label>
        <br>
        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('events.show', ['event' => $event]) }}">Back to event</a>
@endsection