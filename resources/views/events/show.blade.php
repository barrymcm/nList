@extends('layouts.app')

@section('title', 'Event')

@section('content')
    <ul>
        <li>Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
        <li>Category: {{ $event->category->name }}</li>
        <li>Slots Allocated: {{ $event->total_slots }}</li>
        <li>Slots Created: {{ count($event->slots) }}</li>

        @foreach($event->slots as $slot)
            <ul>
                <li>Name: {{ $slot->name }}</li>
                <li>Capacity: {{ $slot->slot_capacity }}</li>
                <li>Start Date: {{ $slot->start_date }}</li>
                <li>End Date: {{ $slot->end_date }}</li>
                <li>Lists:</li>
                <ol>
                    @foreach($slot->applicantLists as $list)
                        <li>
                            <a href="{{ route('applicant_lists.show',
                                ['list' => $list, 'event' => $event]) }}">{{ $list->name . ' ' . $list->id}}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </ul>
            <br>
        @endforeach
    </ul>
    <div>
        <a href="{{ route('events.edit', $event->id) }}">Edit event</a>
        <br>
        <br>
        <a href="{{ route('events.index') }}">Back to events list</a>
        <br>
        <br>
        <form action="{{ route('events.destroy', $event->id) }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" name="submit" value="Delete">
        </form>
    </div>
@endsection