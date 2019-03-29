@extends('layouts.app')

@section('title', 'Select account type')

@section('content')

<div>
	<a href={{ route("register", ['type' => 'organiser']) }}>Organiser</a>
	<br><br>
	<a href={{ route("register", ['type' => 'applicant', 'list' => $list, 'event' => $event]) }}>Applicant</a>
</div>

@endsection