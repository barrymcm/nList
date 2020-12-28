@extends('layouts.app')

@section('title', 'Create new account')

@section('content')

<div class="container flex flex-col w-1/3 justify-center border-grey-400 rounded-md border-2 bg-gray-200 border-gray-300 font-thin p-10 m-auto">

	<div class="container flex flex-col mb-5 text-center border-b-1">
		<h3>Choose account type</h3>
	</div>
	
	<div class="flex my-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin w-full">
		<a class="py-2 text-center flex-grow" href={{ route('register', ['type' => 'organiser']) }}>Organiser</a>
	</div>

	<div class="flex my-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin w-full">
		<a class="py-2 text-center flex-grow" href={{ route('register', ['type' => 'customer', 'list' => $list, 'event' => $event]) }}>Customer</a>
	</div>
</div>

@endsection