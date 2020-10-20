@extends('layouts.app')

    

@section('content')
    <h3>{{ $event->name }}</h3>
    <form class="form form-group" action="{{ route('slots.update', $slot) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <input type="hidden" name="event_id" value="{{ $slot->event_id }}">
        <input type="hidden" name="slot_id" value="{{ $slot->id }}">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ $slot->name }}">
        <label for="">Capacity</label>
        <input type="number" name="slot_capacity" value="{{ $slot->slot_capacity }}">
        <label>Lists</label>
        <select name="total_lists" id="">
            @for($i = 1; $i <= 15; $i++)
                @if (@isset($slot->total_lists) && $slot->total_lists == $i)
                    <option selected="{{ $slot->total_lists }}" value="{{ $slot->total_lists }}">
                        {{ $slot->total_lists }}
                    </option>
                @else
                    <option value="{{ $i }}">{{ $i }}</option>
                @endif
            @endfor
        </select>
        <label for="">Start Date</label>
        <input type="date" name="start_date" value="{{ $slot->start_date? $slot->start_date->format('Y-m-d') : '' }}">
        <label for="">End Date</label>
        <input type="date" name="end_date" value="{{ $slot->end_date? $slot->end_date->format('Y-m-d'): '' }}">
        <br>
        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('events.show', ['event' => $event]) }}">Back to event</a>
@endsection