@extends('layouts.app')

@section('title', 'Edit List')

@section('content')
    <form action="{{ route('applicant_lists.update', [$list, 'event' => $event]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="event_id" value="{{ $event }}">

        <label for="name" >List name:</label>
        <input type="text" name="name" value="{{ $list->name }}">
        <label for="max_applicants">Max applicants</label>
        <input type="number" name="max_applicants" value="{{ $list->max_applicants }}" min="1">

        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('applicant_lists.show', [$list, 'event' => $event]) }}">Back</a>
@endsection