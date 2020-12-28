@extends('layouts.app')

@if ($type == 'customer')
    @section('title', 'Register new customer account')
@elseif ($type == 'organiser')
    @section('title', 'Register new organiser account')
@endif

@section('content')
<div class="container flex flex-col w-1/3 justify-center border-grey-400 rounded-md border-2 bg-gray-200 border-gray-300 font-thin p-10 m-auto">

    <form class="w-full" method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="list" value="{{ $list }}">
        <input type="hidden" name="event" value="{{ $event }}">
        
        <div class="flex flex-col mb-5 w-full">
            
            @if ($type == 'customer')
                <label for="name" class="mb-5">Username</label>
            @elseif ($type == 'organiser')
                <label for="name" class="mb-5">Organisation Name</label>
            @endif

            <input id="name" type="text" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex flex-col mb-5 w-full">
            <label for="email" class="mb-5">{{ __('E-Mail Address') }}</label>
            
            <input id="email" type="email" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex flex-col mb-5 w-full">
            <label for="password" class="mb-5">{{ __('Password') }}</label>

            <input id="password" type="password" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex flex-col mb-5 w-full">
            <label for="password-confirm" class="mb-5">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control" name="password_confirmation" required>
        </div>

        <div class="flex justify-center mt-14 mb-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin">
            <button type="submit" class="w-full">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>

<div class="container flex flex-col w-1/3 justify-center mt-7 mx-auto text-sm ">
    <a class="text-blue-700" href="{{ route('register.select_account_type') }}">Back</a>
</div>
@endsection
