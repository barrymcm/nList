@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<div class="container flex flex-col w-1/3 justify-center border-grey-400 rounded-md border-2 bg-gray-200 border-gray-300 font-thin p-10 m-auto">
	<form class="w-full" action="contact" method="post">
		
		<div class="flex flex-col mb-5 w-full">
			<label class="flex my-5" for="name">Name</label>
			<input class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm" name="name" type="text" id="name">
		</div>
		
		<div class="flex flex-col mb-5 w-full">
			<label class="flex my-5" for="email">Email</label>
			<input class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm" type="email" name="email" id="email">
		</div>
		
		<div class="flex flex-col mb-5 w-full">
			<label class="flex my-5" for="message">Message</label>
			<textarea class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm" name="comment" id="contact-text" rows="4">
			</textarea>
		</div>
		
		<div class="flex justify-center mt-14 mb-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin">
			<button class="w-full" type="submit" value="submit" name="submit">
				Submit<button>
		</div>

	</form>
</div>
@endsection