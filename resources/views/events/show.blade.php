@extends('layouts.app')

@section('title', 'Event')

@section('content')
    <ul>
        <li>Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
        <li>Category: {{ $event->category() }}</li>
        <li>Slots: {{ count($event->slots) }}</li>

        @foreach($event->slots as $slot)
            <ul>
                <li>Name: {{ $slot->name }}</li>
                <li>Capacity: {{ $slot->slot_capacity }}</li>
                <li>Start Date: {{ $slot->start_date }}</li>
                <li>End Date: {{ $slot->end_date }}</li>
                <li>Lists:</li>
                <ol>
                    @foreach($slot->applicantLists as $applicantLists)
                        <li>
                            <a href="{{ route('applicant_list.show',
                                ['list_id' => $applicantLists->id, 'event_id' => $event->id])}}">
                                {{ $applicantLists->name }}
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
        <br/>
        <form action="{{ route('events.destroy', $event->id) }}" method="post">
            @csrf
            {{ method_field('DELETE') }}
            <input type="submit" name="submit" value="Delete">
        </form>
    </div>
@endsection