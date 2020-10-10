@extends('layouts.app')

@section('title', 'Event details')

@section('content')
    <h3>Organiser: {{ $event->organiser }}</h3>
    <ul>
        <li>Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
        <li>Category: {{ $event->category->name }}</li>
        <li>Event Slots: {{ $event->total_slots }}</li>

        @foreach($event->slots as $slot)
            <ul>
                <li>Name: {{ $slot->name }}</li>
                <li>Capacity: {{ $slot->slot_capacity }}</li>
                <li>Remaining List Allocation: {{ $slot->availability }}</li>
                <li>Lists:
                    @if($slot->availability > 0)
                        @auth
                        <a href="{{ route('applicant_lists.create', ['slot' => $slot, 'event' => $event]) }}">Add a list</a>
                        @endauth
                    @endif
                </li>

                <ol>
                    @foreach($slot->applicantLists as $list)
                    <li>
                    <a href="{{ route('applicant_lists.show', [$list, 'event' => $event]) }}">{{ $list->name }}</a>
                    &nbsp; : &nbsp; List Capacity : {{ $list->max_applicants }}
                              {{--Remaining Places :  {{ $list->max_applicants - count($list->applicants) }}--}}
                    <a href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">edit</a>
                    <form action="{{ route('applicant_lists.destroy', [$list, 'event' => $event]) }}" method="post">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" name="submit" value="Delete">
                    </form>

                    </li>
                    @endforeach
                </ol>
                <li>Start Date: {{ $slot->start_date }}</li>
                <li>End Date: {{ $slot->end_date }}</li>
            </ul>
            
            @auth
            @if(empty($slot->name))
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Add slot details</a>
                @else
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Edit slot details</a>
            @endif
            @endauth
            <br>
            <br>
        @endforeach
    </ul>
    <div>
        <a href="{{ route('events.index') }}">Back</a>
        <br>
        <br>
        <a href="{{ route('event_organisers.show', $event->event_organiser_id) }}">View Organiser</a>
        <br>
        <br>
        @auth
        <a href="{{ route('slots.create', ['event' => $event]) }}">Add new Slot</a>
        <br>
        <br>
        <a href="{{ route('events.edit', $event->id) }}">Edit event</a>
        <br>
        <br>
        <form action="{{ route('events.destroy', $event->id) }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" name="submit" value="Delete">
        </form>
        @endauth
    </div>
@endsection