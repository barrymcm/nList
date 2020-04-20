@extends('layouts.app')

@section('title', 'Create a new orgainser account')

@section('content')
	<p>It looks like you need to fill out your details!</p>
    <form action="{{ route('event_organisers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $eventOrganiser->user_id }}">
        <label for="name">Organisers Name</label>
        <input name="name" type="text">
        <label for="description">Description</label>
        <input name="description" type="text">
        <input type="submit" value="Submit">
    </form>
    
@endsection