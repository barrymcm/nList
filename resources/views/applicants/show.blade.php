@extends('layouts.app')

@section('title', 'Applicant')

@section('content')
    <ul>
        <li>First Name : {{  $applicant->first_name }}</li>
        <li>Last Name : {{  $applicant->last_name }}</li>
        <li>DOB: {{  $applicant->dob }}</li>
        <li>Gender: {{  $applicant->gender }}</li>
        <li>Gender: {{  $applicant->created_at }}</li>
    </ul>
    <a href="{{ route('applicants.edit', $applicant) }}">Edit details</a>
@endsection