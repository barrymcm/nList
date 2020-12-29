@extends('layouts.app')

@section('title', __('Verify Your Email Address'))

@section('content')
<div class="flex flex-col">
    <div>
        @if( session('warning'))
            {{ session('warning') }}
        @endif
    </div>

    <div>
        @if (session('resent'))
            <div role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <p class="mt-5">
        {{ __('Before proceeding, please check your email for a verification link.') }} 
        </p>
        <p class="mt-5">
        {{ __('If you did not receive the email') }}, 
        </p>
        <form class="flex flex-col text-center justify-start mt-14 mb-5 bg-blue-300 rounded-sm h-10 hover:bg-blue-400 transition ease-in-out duration-150 font-thin w-1/3" action="{{ route('verification.resend') }}" method="POST" >
            @csrf
            <button class="p-2" type="submit" value="{{ __('click here to request another') }}">{{ __('Click here to request another') }}</button>
        </form>
    </div>
</div>
@endsection
