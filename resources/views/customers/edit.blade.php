@extends('layouts.app')

@section('title', 'Edit customer profile')

@section('content')

    <div>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
    </div>
    <form action="{{ route('customers.update', ['id' => $customer->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <input type="hidden" name="user_id" value="{{ $customer->user_id }}">
        <label for="first_name">First Name:</label>

        @if ($customer->first_name)
            <input type="text" name="first_name" value="{{ $customer->first_name }}">
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="{{ $customer->last_name }}">
            <br>
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" value="{{ $customer->dob }}">
            <br>
            <label for="gender">Male</label>
            <input type="radio" name="gender" value="male" {{ $customer->gender == 'male'? 'checked="checked"' : ''}}>
            <br>
            <label for="gender">Female</label>
            <input type="radio" name="gender" value="female" {{ $customer->gender == 'female'? 'checked="checked"' : ''}}>
            <br>
            <label for="phone">Phone</label>
            <input type="number" name="phone" value="{{ $customer->contactDetails->phone }}">
            <br>
            <label for="address_1">Address</label>
            <input type="text" name="address_1" value="{{ $customer->contactDetails->address_1 }}">
            <br>
            <label for="address_2">Address</label>
            <input type="text" name="address_2" value="{{ $customer->contactDetails->address_2 }}">
            <br>
            <label for="address_3">Address</label>
            <input type="text" name="address_3" value="{{ $customer->contactDetails->address_3 }}">
            <br>
            <label for="city">City</label>
            <input type="text" name="city" value="{{ $customer->contactDetails->city }}">
            <br>
            <label for="county">County</label>
            <input type="text" name="county" value="{{ $customer->contactDetails->county }}">
            <br>
            <label for="post_code">Post Code</label>
            <input type="text" name="post_code" value="{{ $customer->contactDetails->post_code }}">
            <br>
            <label for="country">Country</label>
            <input type="text" name="country" value="{{ $customer->contactDetails->country }}">
            <br>
        @else
            <input type="text" name="first_name" value="">
            <br>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="">
            <br>
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" value="">
            <br>
            <label for="gender">Male</label>
            <input type="radio" name="gender" value="male" checked="checked">
            <br>
            <label for="gender">Female</label>
            <input type="radio" name="gender" value="female">
            <br>
            <label for="phone">Phone</label>
            <input type="number" name="phone" value="">
            <br>
            <label for="address_1">Address</label>
            <input type="text" name="address_1" value="">
            <br>
            <label for="address_2">Address</label>
            <input type="text" name="address_2" value="">
            <br>
            <label for="address_3">Address</label>
            <input type="text" name="address_3" value="">
            <br>
            <label for="city">City</label>
            <input type="text" name="city" value="">
            <br>
            <label for="county">County</label>
            <input type="text" name="county" value="">
            <br>
            <label for="post_code">Post Code</label>
            <input type="text" name="post_code" value="">
            <br>
            <label for="country">Country</label>
            <input type="text" name="country" value="">
            <br>
        @endif

        <input type="submit" value="update">
    </form>
    <br>

@endsection