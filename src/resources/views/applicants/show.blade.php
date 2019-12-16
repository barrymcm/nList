@extends('layouts.app')

@section('title', 'Applicant')

@section('content')
    <ul>
        <li>First Name : {{ $applicant->first_name }}</li>
        <li>Last Name : {{ $applicant->last_name }}</li>
        <li>DOB: {{ $applicant->dob }}</li>
        <li>Gender: {{ $applicant->gender }}</li>
        <li>Created: {{ $applicant->created_at }}</li>

        @if($applicant->contactDetails)
            <ul>
                <h3>Contact details</h3>
                <li>Email: {{ $applicant->user->email }}</li>
                <li>Phone: {{ $applicant->contactDetails->phone }}</li>
                <li>Address: {{ $applicant->contactDetails->address_1 }}</li>
                <li>Address: {{ $applicant->contactDetails->address_2 }}</li>
                <li>Address: {{ $applicant->contactDetails->address_3 }}</li>
                <li>City: {{ $applicant->contactDetails->city }}</li>
                <li>Post code: {{ $applicant->contactDetails->post_code }}</li>
                <li>Country: {{ $applicant->contactDetails->country }}</li>
            </ul>
        @endif

    </ul>
    <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="list" value="{{ $list }}">
        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
        <input type="submit" name="submit" value="Delete" >
    </form>
    <br><br>
    <a href="{{ route('applicants.edit', [$applicant, 'event' => $event, 'list' => $list]) }}">Edit</a>
    <br><br>
    <a href="{{ route('applicant_lists.show', ['list' => $list, 'event' => $event]) }}">Back to List</a>
@endsection