@extends('layouts.app')

@section('title', 'List of applicants')

@section('content')

    @foreach($applicants as $applicant)
        <ul>
            <li>{{ $applicant->first_name }} {{ $applicant->last_name }}</li>
            <li><a href="{{ route('applicants.show', $applicant->id) }}">View applicant details</a></li>

            <li>
                <form action="{{ route('applicants.destroy', $applicant->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" name="submit" value="Delete">
                </form>
            </li>
        </ul>
    @endforeach
        <a href="{{ route('applicants.create') }}">Create new applicant</a>
@endsection