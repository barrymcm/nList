@extends('layouts.app')

@section('title', 'Select account type')

@section('content')

<div>
	<a href={{ route("register", ['type' => 'organiser']) }}>Organiser</a>
	<br><br>
	<a href={{ route("register", ['type' => 'customer', 'list' => $list, 'event' => $event]) }}>Customer</a>
</div>

@endsection