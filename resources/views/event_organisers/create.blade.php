@extends('layouts.app')

@section('title', 'Create a new orgainser')

@section('content')

    <form action="{{ route('event_organisers.store') }}" method="POST">
        @csrf
        <label for="name">Organisers Name</label>
        <input name="name" type="text">
        <label for="description">Description</label>
        <input name="description" type="text">
        <input type="submit" value="Submit">
    </form>
    
@endsection