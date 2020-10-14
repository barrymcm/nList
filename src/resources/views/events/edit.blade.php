@extends('layouts.app')

@section('title', 'Edit event details')

@section('content')
    <p>Current slots : {{ $event->total_slots  }}</p>

    <form class="form form-group" action="{{ route('events.update', $event) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ $event->name }}">
        <label for="description">Description</label>
        <input type="text" name="description" value="{{ $event->description }}">
        <label for="category">Category</label>
        <select name="category_id" id="categories">
            @foreach ($categories as $key => $val)
                @if($val->id == $event->category_id)
                    <option value="{{ $val->id}}" selected>{{ $val->name }}</option>
                @else
                    <option value="{{ $val->id}}">{{ $val->name }}</option>
                @endif
            @endforeach
        </select>

        <input type="submit" value="submit">
    </form>
    
    <div><a href="{{ route('events.show', $event) }}">Back</a></div>
@endsection