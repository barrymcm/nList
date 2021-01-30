@extends('layouts.app')
@section('title', 'Edit event details')
@section('content')

@can('update', $event)
<div class="flex flex-row bg-blue-400 rounded-md w-1/4 h-10 p-2 text-white text-center">
    <p class="w-full">Allocated slots : {{ $event->total_slots  }}</p>
</div>
<div class="flex flex-row border-gray-300 w-1/3 my-10 rounded-md justify-between">
    <form class="w-full" action="{{ route('events.update', $event) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <div class="flex justify-between mt-10">
            <label class="py-2" for="name">Name</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="text" name="name" value="{{ $event->name }}">
        </div>
        <div class="flex justify-between mt-10">
            <label class="py-2" for="description">Description</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="text" name="description" value="{{ $event->description }}">
        </div>
        <div class="flex justify-between mt-10">
            <label class="py-2" for="category">Category</label>
            <select class="rounded-md border-2 border-gray-300 h-10 px-5" name="category_id" id="categories">
                @foreach ($categories as $key => $val)
                @if($val->id == $event->category_id)
                <option value="{{ $val->id}}" selected>{{ $val->name }}</option>
                @else
                <option value="{{ $val->id}}">{{ $val->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="flex justify-end mt-16">
            <input class="cursor-pointer rounded-md bg-blue-400 text-white h-10 px-5 hover:bg-blue-700 transition-ease-in-out duration-150" type="submit" value="submit">
        </div>
    </form>
</div>
<div class="flex flex-row text-blue-700 w-1/4 my-5 justify-between">
    <a class="flex items-center pb-3" href="{{ route('events.show', $event) }}">
        <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
            <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
        </svg>
    Back</a>
</div>
@endcan
@endsection