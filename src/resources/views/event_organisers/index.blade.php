@extends('layouts.app')

@section('title', 'Event Organisers')

@section('content')

<div class="grid grid-rows-{{ count($organisers) }} grid-flow-row grid-cols-2 gap-6">
	@foreach($organisers as $organiser)
	<div class="rounded-md p-5 border-2 border-grey-400 leading-loose">
		<ul>
			<li>Name: {{ $organiser->name }}</li>
			<li>Description: {{ $organiser->description }}</li>
			<li class="flex justify-center my-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin">
				<a class="w-full text-center p-1" href="{{ route('event_organisers.show', $organiser ) }}">View Events</a>
			</li>
		</ul>
	</div>
	@endforeach
</div>

@endsection