@extends('layouts.app')

@section('title', __('home.title'))

@section('content')
    <p>{{ __('home.introduction') }}</p>
    <div id='app'> 
    	<p v-text="message"></p>
		<example-component></example-component>
	</div>
@endsection