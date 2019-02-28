@extends('layouts.app')

@section('title', 'Edit Applicant')

@section('content')
    <form class="form form-group" action="{{ route('applicants.update', $applicant) }}" method="post">
        @csrf
        @method('PUT')

        <input type="hidden" name="list" value="{{ $list }}">
        <input type="hidden" name="event" value="{{ $event }}">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" value="{{ $applicant->first_name }}">
        <br><br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" value="{{ $applicant->last_name }}">
        <br><br>
        <label for="dob">DoB</label>
        <input type="date" name="dob" value="{{ $applicant->dob }}">
        <br><br>
        <span>Gender</span>
        <br>
        <label for="gender">Male</label>
        <input type="radio" name="gender" value="male" {{ $applicant->gender == 'male'? 'checked="checked"' : ''}}>
        <label for="gender">Female</label>
        <input type="radio" name="gender" value="female" {{ $applicant->gender == 'female'? 'checked="checked"' : ''}}>
        <br><br>
        <label for="phone">Phone</label>
        <input type="number" name="phone" value="{{ $applicant->contactDetails->phone }}">
        <br><br>
        <label for="address_1">Address</label>
        <input type="text" name="address_1" value="{{ $applicant->contactDetails->address_1 }}">
        <br><br>
        <label for="address_2">Address</label>
        <input type="text" name="address_2" value="{{ $applicant->contactDetails->address_2 }}">
        <br><br>
        <label for="address_3">Address</label>
        <input type="text" name="address_3" value="{{ $applicant->contactDetails->address_3 }}">
        <br><br>
        <label for="city">City</label>
        <input type="text" name="city" value="{{ $applicant->contactDetails->city }}">
        <br><br>
        <label for="county">County</label>
        <input type="text" name="county" value="{{ $applicant->contactDetails->county }}">
        <br><br>
        <label for="post_code">Post Code</label>
        <input type="text" name="post_code" value="{{ $applicant->contactDetails->post_code }}">
        <br><br>
        <label for="country">Country</label>
        <input type="text" name="country" value="{{ $applicant->contactDetails->country }}">
        <br><br>
        <input type="submit" value="submit">
    </form>
    <br>
    <a href="{{ route('applicants.show', [$applicant, 'list' => $list, 'event' => $event]) }}">Cancel</a>
@endsection