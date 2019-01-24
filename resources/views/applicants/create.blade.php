@extends('layouts.app')

@section('title', 'Create Applicant')

@section('content')

    <form action="{{ route('applicants.store') }}" method="POST">
        @csrf
        <input type="text" name="first_name" value="">
        <input type="text" name="last_name" value="">
        <input type="date" name="dob" value="">
        <input type="radio" name="gender" value="male" checked="checked">
        <input type="radio" name="gender" value="female">
        <input type="submit" value="submit">
    </form>

@endsection