@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container flex w-1/3 justify-center border-grey-400 rounded-md border-2 bg-gray-200 border-gray-300 font-thin p-10 m-auto">

    <form class="w-full" method="POST" action="{{ route('login') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" name="list" value=" {{ $list }}">
        <input type="hidden" name="event" value=" {{ $event }}">

        <div class="flex flex-col mb-5 w-full">
            <label for="email" class="mb-5">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex flex-col w-full">
            <label for="password" class="mb-5">{{ __('Password') }}</label>
            <input id="password" type="password" class="px-5 focus:outline-none focus:ring focus:border-blue-300 h-10 rounded-sm form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="flex w-full justify-between">
            <div class="flex my-5 text-sm items-center">
                <input class="justify-start" type="checkbox" name="remember" id="remember" 
                {{ old("remember") ? "checked" : "" }}>

                <label class="ml-2" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="my-5 text-sm">
            @if (Route::has('password.request'))
                <a class="text-blue-700" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                </a>
            @endif    
            </div>
        </div>

        <div class="flex justify-center my-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin">
            <button class="flex-grow" type="submit" >
                {{ __('Login') }}
            </button>
        </div>        
    </form>
</div>
@endsection
