@extends('layouts.app')

@section('title', __('home.title'))

@section('content')
    <div> 
    <p>{{ __('home.introduction') }}</p>
		<example-component></example-component>
		<br>
		<home-component></home-component>
	</div>
@endsection