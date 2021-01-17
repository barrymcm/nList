@extends('layouts.app')
@section('title', 'Edit slot details')
@section('content')
<div class="flex flex-row bg-blue-400 rounded-md w-1/4 h-10 p-2 text-white text-center">
    <div class="w-full">
        {{ $event->name }}
    </div>
</div>
<div class="flex flex-row border-gray-300 w-1/2 my-10 rounded-md justify-between">
    <form class="w-full" action="{{ route('slots.update', $slot) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="flex justify-between my-5">
            <input type="hidden" name="event_id" value="{{ $slot->event_id }}">
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="hidden" name="slot_id" value="{{ $slot->id }}">
        </div>
        <div class="flex justify-between my-5">
            <label for="name">Name</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="text" name="name" value="{{ $slot->name }}">
        </div>
        
        <div class="flex justify-between my-5">
            <label for="">Capacity</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="number" name="slot_capacity" value="{{ $slot->slot_capacity }}">
        </div>

        <div class="flex justify-between my-5 h-10">
            <label>No of Lists</label>
            <select class="order-2 rounded-md border-2 border-gray-300 h-10 px-5" name="total_lists" id="">
                @for($i = 1; $i <= 15; $i++)
                    @if (@isset($slot->total_lists) && $slot->total_lists == $i)
                        <option selected="{{ $slot->total_lists }}" value="{{ $slot->total_lists }}">{{ $slot->total_lists }}
                        </option>
                    @else
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                @endfor
            </select>
        </div>

        <div class="flex justify-between mt-10">
            <label for="">Start Date</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="date" name="start_date" value="{{ $slot->start_date ? $slot->start_date->format('Y-m-d') : '' }}">
        </div>

        <div class="flex justify-between my-5">
            <label for="">Start Time</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="time" name="start_time" value="{{ ($slot->start_date != NULL)?
            $slot->start_date->hour . ':' . $slot->start_date->minute : ''
            }}">
        </div>

        <div class="flex justify-between mt-10">
            <label for="">End Date</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="date" name="end_date" value="{{ $slot->end_date ? $slot->end_date->format('Y-m-d') : '' }}">
        </div>

        <div class="flex justify-between my-5">
            <label for="">End Time</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="time" name="end_time" value="{{ ($slot->end_date != NULL)?
            $slot->end_date->hour . ':' .  $slot->end_date->minute : ''
            }}">
        </div>

        <div class="flex justify-end mt-16">
            <input class="cursor-pointer rounded-md bg-blue-400 text-white h-10 px-5 hover:bg-blue-700 transition-ease-in-out duration-150" type="submit" value="submit">
        </div>
    </form>
</div>
<div class="flex flex-row text-blue-700 w-1/4 my-5 justify-between">
    <a class="flex items-center pb-3" href="{{ route('events.show', ['event' => $event]) }}">
        <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
            <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
        </svg>
    Back to event</a>
</div>
@endsection