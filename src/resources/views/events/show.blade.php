@extends('layouts.app')

@section('title', 'Event details')

@section('content')
<div class="flex flex-col leading-loose">
    @if(session()->has('message') || session()->has('notice'))
        <div class="">
            <h3>{{ session('message') }}</h3>
            <h3>{{ session('notice') }}</h3>
        </div>
    @endif

    <section class="w-full">
        <div class="flex flex-row justify-end h-10 mb-5">
            @can('update', $event)
                <a class="bg-green-500 text-white rounded-md px-3 pt-1 mx-5" href="{{ route('slots.create', ['event_id' => $event]) }}">Add new Slot</a>
                <a class="bg-yellow-400 text-white rounded-md px-3 pt-1 mx-5" href="{{ route('events.edit', $event->id) }}">Edit event details</a>
            @endcan

            @can('delete', $event)
                <form action="{{ route('events.destroy', $event->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input class="bg-red-600 text-white rounded-md px-3 ml-5 h-10 cursor-pointer" type="submit" name="submit" value="Delete">
                </form>
            @endcan
        </div>
        <div class="grid grid-cols-2 rounded-md grid-flow-row mb-5 justify-between h-10 bg-blue-400 text-white px-5 py-1">
            <div class="text-left ">Event Name: {{ $event->name }}</div>
            <div class="text-right">Organiser: {{ $event->organiser }}</div>
        </div>    
        <div class="grid grid-cols-2 rounded-md grid-flow-row mb-5 justify-between h-10 bg-blue-400 text-white px-5 py-1">
            <div class="">Description: {{ $event->description }}</div>
            <div class="">Category: {{ $event->category->name }}</div>
        </div>
    </section>
    
    <header class="w-1/3 grid grid-cols-1 my-10 bg-blue-400 h-14 text-white text-center rounded-md p-3">
        <p>There are {{ $event->total_slots }} slots allocated to this event.</p>
    </header>

    <div class="grid grid-cols-2 gap-4">
    @foreach($event->slots as $slot)
        <div class="w-full rounded-md grid-flow-row mb-5 justify-between h-auto bg-gray-300 text-thin p-5 gap-6">
            <div class="flex flex-row justify-between h-14 my-5 mr-5 border-b-2 border-gray-400">
                <p class="font-semibold">{{ $slot->name }}</p>

                @can('update', $event)
                    @if(@empty($slot->name))
                        <a class="h-10 rounded-md bg-green-400 hover:bg-green-600 transition-ease-in-out duration-150 text-center px-3 w-auto py-1" href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Add slot details</a>
                    @else
                        <a class="h-10 rounded-md bg-yellow-400 hover:bg-yellow-600 transition-ease-in-out duration-150 text-center px-3 w-auto py-1" href="{{ route('slots.edit', ['slot' => $slot->id, 'event' => $event->id])}}">Edit slot</a>
                    @endif
                        <form action="{{ route('slots.destroy', [$slot, 'event' => $event]) }}" method="POST">
                            @csrf
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="slot" value="{{ $slot->id }}">
                            <input type="hidden" name="event" value="{{ $event->id }}">
                            <input class="h-10 cursor-pointer rounded-md bg-red-600 transition-ease-in-out duration-150 text-center text-white px-3 w-auto" type="submit" name="submit" value="Cancel Slot">
                        </form>
                @endcan
                
                @if ($slot->deleted_at != null) 
                    <div class="text-center rounded-md h-10 w-1/6 bg-red-400 text-white py-1">Canceled</div>
                @else
                    <div class="text-center align-middle rounded-md h-10 w-1/6 bg-green-500 text-white py-1">Active</div>
                @endif
            </div>

            @if ($slot->start_date != NULL && $slot->end_date != NULL)
                <div class="grid grid-row-2 col-span-2">
                    <div class="grid grid-row">
                        Date : {{ 
                            $slot->start_date->shortEnglishDayOfWeek . ' ' . 
                            $slot->start_date->day . ' ' .
                            $slot->start_date->shortEnglishMonth . ' ' .
                            $slot->start_date->year
                        }}
                    </div>
                    
                    <div class="grid grid-row">
                        <p>
                            Time : {{ $slot->start_date->format('g:i a') }} - {{ $slot->end_date->format('g:i a') }}
                        </p>
                    </div> 
                </div>
            @endif
            
            @if ($slot->deleted_at != null) 
                <div class="flex flex-row w-full">
                    <p class="inline-block text-right w-full">
                        This slot has been canceled!
                    </p>
                </div>
            @else

                @can('update', $event)
                    <div class="flex flex-row mb-5 justify-between">
                        <p>Slot capacity {{ $slot->slot_capacity }}</p>
                        <p>Slot availability {{ $slot->availability }}</p>
                    </div>
                @endcan
                
                    @if($slot->slot_capacity > 0)
                        @can('update', $event)
                        <div class="flex flex-row mb-5 pt-5 border-t-2 border-gray-700 justify-between">
                            <p class="flex flex-row-reverse">Lists {{$slot->total_lists}}</p>
                            @if (@count($slot->applicantLists) < $slot->total_lists)
                                    <a class="w-1/4 rounded-md h-10 bg-green-500 text-white text-center py-1 w-1/4 hover:bg-green-700 transition-ease-in-out duration-150" href="{{ route('applicant_lists.create', ['slot' => $slot, 'event' => $event]) }}">Create new list</a>
                            @endif
                        </div>
                        @endcan
                    @endif    

                @foreach($slot->applicantLists as $list)
                    @if (!isset($list->deleted_at))
                    <div class="grid grid-rows-{{ @count($slot->applicantLists) }} grid-cols-7 gap-3 grid-flow-auto my-5 pt-5 border-t-2 border-gray-700 text-center">
                    @else
                    <div class="grid grid-rows-2 grid-cols-5 grid-flow-auto mb-5 pt-5 text-center">
                    @endif
                        <div class=""></div>
                        <div class=""></div>
                        <div class=""></div>
                        <div class="">Capacity</div>
                        <div class="">Availability</div>
                        <a class="col-span-3 bg-blue-400 hover:bg-blue-700 transition-ease-in-out duration-150 rounded-md text-center text-white px-3 w-auto" href="{{ route('applicant_lists.show', [$list, 'event' => $event]) }}">{{ $list->name }}</a>
                        <p class="col-start-4">{{ $list->max_applicants }}</p>
                        <p class="col-start-5">{{ $list->max_applicants - count($list->applicants) }}</p>
                   
                        @can('update', $event)
                            <a class="rounded-md bg-yellow-400 hover:bg-yellow-600 transition-ease-in-out duration-150 text-center px-3 w-auto" href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">edit</a>

                            <form action="{{ route('applicant_lists.destroy', [$list, 'event' => $event]) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input class="cursor-pointer rounded-md bg-red-600 transition-ease-in-out duration-150 text-center text-white px-3 w-auto" type="submit" name="submit" value="Cancel">
                            </form>
                        @endcan
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
    </div>
</div>

<div class="flex flex-col my-10">
    <div class="flex leading-loose text-blue-700 justify-between">
        <a class="flex items-center pb-3" href="{{ route('events.index') }}">
            <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
            </svg>
        Back</a>
    
        <a class="block leading-loose text-blue-700" href="{{ route('event_organisers.show', $event->event_organiser_id) }}">
            View Organiser
        </a>        
    </div>
</div>
@endsection