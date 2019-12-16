@extends('layouts.app')

@section('title', 'List of applicants')

@section('content')

    @foreach($applicants as $applicant)
        <ul>
            <li>First Name : {{  $applicant->first_name }}</li>
            <li>Last Name : {{  $applicant->last_name }}</li>
            <li>DOB: {{  $applicant->dob }}</li>
            <li>Gender: {{  $applicant->gender }}</li>
            <li>Gender: {{  $applicant->created_at }}</li>
        </ul>
    @endforeach

@endsection