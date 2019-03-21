@extends('layouts.app')

@section('title', 'Create account type')

@section('content')

<div>
	<a href={{ route("register", ['type' => 'organiser']) }}>Organiser</a>
	<br><br>
	<a href={{ route("register", ['type' => 'applicant']) }}>Applicant</a>
</div>

@endsection