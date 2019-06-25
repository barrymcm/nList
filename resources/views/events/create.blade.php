@extends('layouts.app')

@section('title', 'Create event')

@section('content')

    <form class="form form-group" action="{{ route('events.store') }}" method="post">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" value="">
        <label for="description">Description</label>
        <input type="text" name="description" value="">
        <label for="category">Category</label>
        <select name="category_id" id="categories">
            @foreach ($categories as $key => $val)
                    <option value="{{ $val->id}}">{{ $val->name }}</option>
            @endforeach
        </select>
        <label for="slots">Slots</label>
        <select name="total_slots" id="">
            @for($i = 1; $i <= 15; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
        <input type="submit" value="submit">
    </form>
    <br>
    <div><a href="{{ route('events.index') }}">Back to events</a></div>
@endsection