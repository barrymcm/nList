@extends('layouts.app')

@section('title', 'Edit Applicant')

@section('content')
    <form class="form form-group" action="{{ route('applicants.update', $applicant) }}" method="post">
        @csrf
        {{ method_field('PATCH') }}
        <input type="text" name="first_name" value="{{ $applicant->first_name }}">
        <input type="text" name="last_name" value="{{ $applicant->last_name }}">
        <label for="dob">DoB</label>
        <input type="date" name="dob" value="{{ $applicant->dob }}">
        <label for="gender">Male</label>
        <input type="radio" name="gender" value="male" checked="checked">
        <label for="gender">Female</label>
        <input type="radio" name="gender" value="female">
        <input type="submit" value="submit">
    </form>
@endsection