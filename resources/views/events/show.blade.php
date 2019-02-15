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
                <li>Allocated List Places: {{ $slot->availability }}</li>
                <li>Lists:
                    @if($slot->availability != 'Full')
                    <a href="{{ route('applicant_lists.create', ['slot' => $slot, 'event' => $event]) }}">Add a list</a>
                @endif
                </li>

                <ol>
                    @foreach($slot->applicantLists as $list)
                        <li>
                            <a href="{{ route('applicant_lists.show',
                                ['list' => $list, 'event' => $event]) }}">{{ $list->name }}
                            </a>
                            &nbsp; : &nbsp; List Quantity : {{ $list->max_applicants }}
                        </li>
                    @endforeach
                </ol>
                <li>Start Date: {{ $slot->start_date }}</li>
                <li>End Date: {{ $slot->end_date }}</li>
            </ul>
            @if(empty($slot->name))
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Add slot details</a>
                @else
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Edit slot details</a>
            @endif
            <br>
            <br>
        @endforeach
    </ul>
    <div>
        <a href="{{ route('slots.create', ['event' => $event]) }}">Add new Slot</a>
        <br>
        <br>
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