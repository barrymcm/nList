<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ul class="navbar-nav ml-auto">
        <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('contact_us') }}">Contact</a></li>
        <li><a href="{{ route('events.index') }}">Events</a></li>
        <li><a href="{{ route('event_organisers.index') }}">Event Organisers</a></li>
    </ul>
    <br/>
    <ul>
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register.select_account_type') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @endguest

        @if (Auth::check())
        <div>{{ Auth::user()->name }} <span class="caret"></span></div>
        <div>
            @if (Auth::user()->customer)
                {{--Note: Watch this as there was an orphan user that didnt have a role that broke this--}}

                <a href="{{ route('customers.show', Auth::user()->customer->id) }}">My Account</a>
            @endif
        </div>
        <div>
            @if (Auth::user()->eventOrganiser)
                <a href="{{ route('event_organisers.show', Auth::user()->eventOrganiser->id) }}">My Account</a>
            @endif
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="submit" name="Logout" value="Logout">
        </form>
        @endif
    </ul>
@show

<h1>@yield('title')</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('content')
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>