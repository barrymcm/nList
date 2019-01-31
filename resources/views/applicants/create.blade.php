@extends('layouts.app')

@section('title', 'Create Applicant')

@section('content')

    <form action="{{ route('applicants.store') }}" method="POST">
        @csrf
        <input type="hidden" name="list_id" value="{{ $list }}">
        <input type="hidden" name="event_id" value="{{ $event }}">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" value="">
        <label for="gender">Male</label>
        <input type="radio" name="gender" value="male" checked="checked">
        <label for="gender">Female</label>
        <input type="radio" name="gender" value="female">
        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('applicant_lists.show', ['list' => $list, 'event' => $event]) }}">Back to List</a>

@endsection