@extends('layouts.app')

@section('title', 'Create customer profile')

@section('content')

<div>
    @if (session('verified'))
        <p>You'll need to create your profile before you can add yourself to a list</p>
    @endif

</div>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId }}">
        <label for="first_name">First Name:</label>
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
        <input type="submit" value="submit">
    </form>
    <br>

@endsection