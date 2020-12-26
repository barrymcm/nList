<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div id="app" class="container-lg flex flex-col h-screen justify-between">
        <nav class="w-full flex flex-row w-full justify-end py-3 px-10 bg-gray-900">
                <div id="login-reg" class="flex flex-row space-x-10">
                    @guest
                        <div class="text-sm text-gray-300 hover:text-white">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </div>
                        @if (Route::has('register'))
                            <div class="text-sm text-gray-300 hover:text-white">
                                <a class="nav-link" href="{{ route('register.select_account_type') }}">{{ __('Register') }}</a>
                            </div>
                        @endif
                    @endguest

                    @if (Auth::check())
                    <div>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </div>
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
                </div>
        </nav>
         
        <nav>
            <ul class="repo-nav border-b border-grey-400 flex items-center px-12 pt-10 bg-gray-100 text-base h-25 font-thin">
                <li class="pl-5"> 
                    <a href="{{ route('home') }}" class="flex items-center border-b-2 border-red-500 px-4 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path fill-rule="evenodd" d="M8.156 1.835a.25.25 0 00-.312 0l-5.25 4.2a.25.25 0 00-.094.196v7.019c0 .138.112.25.25.25H5.5V8.25a.75.75 0 01.75-.75h3.5a.75.75 0 01.75.75v5.25h2.75a.25.25 0 00.25-.25V6.23a.25.25 0 00-.094-.195l-5.25-4.2zM6.906.664a1.75 1.75 0 012.187 0l5.25 4.2c.415.332.657.835.657 1.367v7.019A1.75 1.75 0 0113.25 15h-3.5a.75.75 0 01-.75-.75V9H7v5.25a.75.75 0 01-.75.75h-3.5A1.75 1.75 0 011 13.25V6.23c0-.531.242-1.034.657-1.366l5.25-4.2h-.001z"></path>
                        </svg>
                        <span class="ml-2">Home</span>
                    </a>
                </li>
                <li class="pl-5">
                    <a href="{{ route('about') }}" class="flex items-center border-b-2 border-transparent hover:border-gray-500 transition ease-in-out duration-150 px-4 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path fill-rule="evenodd" d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zM0 8a8 8 0 1116 0A8 8 0 010 8zm6.5-.25A.75.75 0 017.25 7h1a.75.75 0 01.75.75v2.75h.25a.75.75 0 010 1.5h-2a.75.75 0 010-1.5h.25v-2h-.25a.75.75 0 01-.75-.75zM8 6a1 1 0 100-2 1 1 0 000 2z"></path>
                        </svg>
                        <span class="ml-2">About</span>
                    </a>
                </li> 
                <li class="pl-5">
                    <a href="{{ route('contact_us') }}" class="flex items-center border-b-2 border-transparent hover:border-gray-500 transition ease-in-out duration-150 px-4 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path fill-rule="evenodd" d="M1.5 2.75a.25.25 0 01.25-.25h8.5a.25.25 0 01.25.25v5.5a.25.25 0 01-.25.25h-3.5a.75.75 0 00-.53.22L3.5 11.44V9.25a.75.75 0 00-.75-.75h-1a.25.25 0 01-.25-.25v-5.5zM1.75 1A1.75 1.75 0 000 2.75v5.5C0 9.216.784 10 1.75 10H2v1.543a1.457 1.457 0 002.487 1.03L7.061 10h3.189A1.75 1.75 0 0012 8.25v-5.5A1.75 1.75 0 0010.25 1h-8.5zM14.5 4.75a.25.25 0 00-.25-.25h-.5a.75.75 0 110-1.5h.5c.966 0 1.75.784 1.75 1.75v5.5A1.75 1.75 0 0114.25 12H14v1.543a1.457 1.457 0 01-2.487 1.03L9.22 12.28a.75.75 0 111.06-1.06l2.22 2.22v-2.19a.75.75 0 01.75-.75h1a.25.25 0 00.25-.25v-5.5z"></path>
                        </svg>
                        <span class="ml-2">Contact</span>
                    </a>
                </li>
                <li class="pl-5">
                    <a href="{{ route('events.index') }}" class="flex items-center border-b-2 border-transparent hover:border-gray-500 transition ease-in-out duration-150 px-4 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path fill-rule="evenodd" d="M1.75 1A1.75 1.75 0 000 2.75v4c0 .372.116.717.314 1a1.742 1.742 0 00-.314 1v4c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0016 12.75v-4c0-.372-.116-.717-.314-1 .198-.283.314-.628.314-1v-4A1.75 1.75 0 0014.25 1H1.75zm0 7.5a.25.25 0 00-.25.25v4c0 .138.112.25.25.25h12.5a.25.25 0 00.25-.25v-4a.25.25 0 00-.25-.25H1.75zM1.5 2.75a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v4a.25.25 0 01-.25.25H1.75a.25.25 0 01-.25-.25v-4zm5.5 2A.75.75 0 017.75 4h4.5a.75.75 0 010 1.5h-4.5A.75.75 0 017 4.75zM7.75 10a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5zM3 4.75A.75.75 0 013.75 4h.5a.75.75 0 010 1.5h-.5A.75.75 0 013 4.75zM3.75 10a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5z"></path>
                        </svg>
                        <span class="ml-2">Events</span>
                    </a>
                </li>
                <li class="pl-5">
                    <a href="{{ route('event_organisers.index') }}" class="flex items-center border-b-2 border-transparent hover:border-gray-500 transition ease-in-out duration-150 px-4 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                            <path fill-rule="evenodd" d="M1.5 14.25c0 .138.112.25.25.25H4v-1.25a.75.75 0 01.75-.75h2.5a.75.75 0 01.75.75v1.25h2.25a.25.25 0 00.25-.25V1.75a.25.25 0 00-.25-.25h-8.5a.25.25 0 00-.25.25v12.5zM1.75 16A1.75 1.75 0 010 14.25V1.75C0 .784.784 0 1.75 0h8.5C11.216 0 12 .784 12 1.75v12.5c0 .085-.006.168-.018.25h2.268a.25.25 0 00.25-.25V8.285a.25.25 0 00-.111-.208l-1.055-.703a.75.75 0 11.832-1.248l1.055.703c.487.325.779.871.779 1.456v5.965A1.75 1.75 0 0114.25 16h-3.5a.75.75 0 01-.197-.026c-.099.017-.2.026-.303.026h-3a.75.75 0 01-.75-.75V14h-1v1.25a.75.75 0 01-.75.75h-3zM3 3.75A.75.75 0 013.75 3h.5a.75.75 0 010 1.5h-.5A.75.75 0 013 3.75zM3.75 6a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5zM3 9.75A.75.75 0 013.75 9h.5a.75.75 0 010 1.5h-.5A.75.75 0 013 9.75zM7.75 9a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5zM7 6.75A.75.75 0 017.75 6h.5a.75.75 0 010 1.5h-.5A.75.75 0 017 6.75zM7.75 3a.75.75 0 000 1.5h.5a.75.75 0 000-1.5h-.5z"></path>
                        </svg>
                        <span class="ml-2">Event Organisers</span>
                    </a>
                </li>
            </ul>    
        </nav>
    
        @show

        <header class="mb-9 mt-14 w-3/4 border-solid rounded-md border-2 border-light-grey-500 mx-auto p-5">
            <h1>@yield('title')</h1>
        </header>

        <section id="errors" class="px-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        <main class="h-3/4 w-3/4 border-solid rounded-md border-2 border-light-grey-500 p-10 mb-auto mx-auto">
            @yield('content')
        </main>

        <footer class="flex flex-row h-10 px-10 py-2 w-full border-t-2 font-thin text-sm mt-20">
            <div class="w-full px-3">
                <p class="text-gray-400">This is the footer</p>
            </div>
        </footer>
    </div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>