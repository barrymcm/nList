@extends('layouts.app')

@section('title', 'Event details')

@section('content')

    <h3>Organiser: {{ $event->organiser }}</h3>
    <ul>
        <li>Event Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
        <li>Category: {{ $event->category->name }}</li>
        <li>Event Slots: {{ $event->total_slots }}</li>
        <br>
    </ul>

    @if(session()->has('message') || session()->has('notice'))
        <div class="alert alert-message">
            <h3>{{ session('message') }}</h3>
            <h3>{{ session('notice') }}</h3>
        </div>
    @endif

    @foreach($event->slots as $slot)     
    <ul>
        <li>Slot Name: {{ $slot->name }}</li>
        
        @if ($slot->deleted_at != null) 
            <li>Status: Canceled</li>
        @else
            <li>Status: Active</li>
            <li>Total slot capacity: {{ $slot->slot_capacity }}</li>
            <li>Lists allocated: {{ $slot->total_lists }}</li>
            <li>Remaining slot allocation: {{ $slot->availability }}</li>

            @if($slot->slot_capacity > 0)
                @can('update', $event)
                    @if (@count($slot->applicantLists) < $slot->total_lists)
                        <li>Lists:
                            <a href="{{ route('applicant_lists.create', ['slot' => $slot, 'event' => $event]) }}">Add a list</a>
                        </li>
                    @endif
                @endcan
            @endif
            <ol>
                @foreach($slot->applicantLists as $list)
                    <li>

                    <a href="{{ route('applicant_lists.show', [$list, 'event' => $event]) }}">{{ $list->name }}</a>
                    &nbsp; : &nbsp; List Capacity : {{ $list->max_applicants }} {{--Remaining Places :  {{ $list->max_applicants - count($list->applicants) }}--}}
                    
                    @can('update', $event)
                        <div>
                            <a href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">edit</a>

                            <form action="{{ route('applicant_lists.destroy', [$list, 'event' => $event]) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="submit" name="submit" value="Cancel">
                            </form>
                        </div>
                    @endcan

                    </li>
                @endforeach
            </ol>
            <br><br>
            @if ($slot->start_date != NULL && $slot->end_date != NULL)
            <li>Start Date: {{ 
                $slot->start_date->englishDayOfWeek . ' ' . 
                $slot->start_date->day . ' ' .
                $slot->start_date->shortEnglishMonth . ' ' .
                $slot->start_date->year
            }}</li>
            
            <li>Start Time: {{ 
                $slot->start_date->hour . ':' . 
                $slot->start_date->minute
            }}</li>
            
            <br>
            <li>End Date: {{ 
                $slot->end_date->englishDayOfWeek . ' ' . 
                $slot->end_date->day . ' ' .
                $slot->end_date->shortEnglishMonth . ' ' .
                $slot->end_date->year
            }}</li>
            
            <li>End Time: {{ 
                $slot->end_date->hour . ':' . 
                $slot->end_date->minute
            }}</li>
            @endif
            <br>
        @endif

        @can('update', $event)
            @if(@empty($slot->name))
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Add slot details</a><br>
            @else
                <a href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Edit slot details</a><br>
            @endif
                <br>
                <form action="{{ route('slots.destroy', [$slot, 'event' => $event]) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="slot" value="{{ $slot->id }}">
                    <input type="hidden" name="event" value="{{ $event->id }}">
                    <input type="submit" name="submit" value="Cancel Slot">
                </form>
                <br>
        @endcan
        <br>
        <br>
    @endforeach
    </ul>

    <div>
        <a href="{{ route('events.index') }}">Back</a>
        <br>
        <br>
        <a href="{{ route('event_organisers.show', $event->event_organiser_id) }}">View Organiser</a>
        @can('update', $event)
                <br>
                <br>
                <a href="{{ route('slots.create', ['event_id' => $event]) }}">Add new Slot</a>
                <br>
                <br>
                <a href="{{ route('events.edit', $event->id) }}">Edit event details</a>
                <br>
                <br>
        @endcan

        @can('delete', $event)
            <form action="{{ route('events.destroy', $event->id) }}" method="post">
                @csrf
                {{ method_field('DELETE') }}
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="submit" name="submit" value="Delete">
            </form>
        @endcan        
    </div>
@endsection