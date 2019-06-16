@extends('layouts.app')

@section('title', 'Customer')

@section('content')

    <ul>
        <li>First Name : {{ $customer->first_name }}</li>
        <li>Last Name : {{ $customer->last_name }}</li>
        <li>DOB: {{ $customer->dob }}</li>
        <li>Gender: {{ $customer->gender }}</li>
        <li>Created: {{ $customer->created_at }}</li>

        @if($customer->contactDetails)
            <ul>
                <h3>Contact details</h3>
                <li>Email: {{ $customer->user->email }}</li>
                <li>Phone: {{ $customer->contactDetails->phone }}</li>
                <li>Address: {{ $customer->contactDetails->address_1 }}</li>
                <li>Address: {{ $customer->contactDetails->address_2 }}</li>
                <li>Address: {{ $customer->contactDetails->address_3 }}</li>
                <li>City: {{ $customer->contactDetails->city }}</li>
                <li>Post code: {{ $customer->contactDetails->post_code }}</li>
                <li>Country: {{ $customer->contactDetails->country }}</li>
            </ul>
        @endif

    </ul>
    <form action="{{ route('customers.destroy', $customer) }}" method="POST">
        @csrf
        @method('DELETE')
        {{--<input type="hidden" name="list" value="{{ $list }}">--}}
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <input type="submit" name="submit" value="Delete" >
    </form>
    <br><br>
    <a href="{{ route('customers.edit', [$customer]) }}">Edit</a>
    <br><br>
    {{--<a href="{{ route('customer_lists.show', ['list' => $list, 'event' => $event]) }}">Back to List</a>--}}
@endsection