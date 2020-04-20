@extends('layouts.app')

@section('title', __('registered.title'))

@section('content')
    <p>{{ __('registered.description') }}</p>
    @if (Auth::user()->eventOrganiser)
	    <p>Click 
	    	<a href="{{ route('event_organisers.create', ['id' => Auth::user()->eventOrganiser->user_id]) }}">here
	        </a> to add your details here!
	    </p>
	@elseif (Auth::user()->customer)
	    <p>Click 
	    	<a href="{{ route('customers.create', ['id' => Auth::user()->customer->id]) }}">here
	        </a> to add your details here!
	    </p>
	@endif
@endsection


