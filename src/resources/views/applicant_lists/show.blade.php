@extends('layouts.app')

@section('title', 'Listing')

@section('content')
    <table>
        <head>
            <tr>
                <th>Event Name</th>
                <th>List Name</th>
                <th>Max Applicants</th>
                <th>Available Places</th>
                <th>Name</th>
                <th>Application date</th>
                <th>Time</th>
            </tr>
        </head>
        <tbody>
        <tr>
            <td>{{ $event->name }}</td>
            <td>{{ $list->name }}</td>
            <td>{{ $list->max_applicants }}</td>
            <td>{{ $list->max_applicants - count($list->applicants)}}</td>
        </tr>
        @foreach($list->applicants as $applicant)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                <td>{{ $applicant->created_at->format('l jS \\of F Y') }}</td>
                <td>{{ $applicant->created_at->format('h:i:s A') }}</td>
                <td><a href="{{ route('applicants.show', [$applicant, 'event' => $event, 'list' => $list]) }}">Details</a></td>
                <td>
                    <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                        <input type="hidden" name="event" value="{{ $event }}">
                        <input type="hidden" name="list_id" value="{{ $list->id }}">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if( session('warning'))
        <br>
        {{ session('warning') }} <br><br><a href="{{ route('login', ['list' => $list, 'event' => $event]) }}">sign in?</a>
        or if you dont have an account you can
        <a href="{{ route('register.select_account_type', ['list' => $list, 'event' => $event]) }}">register</a>
    @endif

    @if( session('notice'))
        <p class="alert-info">
            {{ session('notice') }} <a href="{{ route('customers.create', ['id' => auth()->user()->customer]) }}">Click here!</a>
        </p>
    @endif
    <br><br>
    @if(count($list->applicants) < $list->max_applicants)
        <a href="{{ route('applicants.create', [ 'list' => $list, 'event' => $event]) }}">Add me!</a>
        @auth
        <br><br>
        <a href="{{ route('applicants.create', [$list, 'event' => $event]) }}">Add applicant!</a>
        @endauth
    @endif
    <br><br>
    <a href="{{ route('events.show', $event) }}">Back to Slot</a>
    <br><br>
    @auth
    <a href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">Edit List</a>
    <br><br>
    @if(count($list->applicants) < 1)
        <form action="{{ route('applicant_lists.destroy', $list->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="event" value="{{ $event }}">
            <input type="submit" name="submit" value="Delete List">
        </form>
    @endif
    <br>
    @endauth
@endsection