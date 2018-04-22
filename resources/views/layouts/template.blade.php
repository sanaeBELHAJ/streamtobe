<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title')</title>
    
        <!-- CSS -->
        {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
        {!! HTML::style('fontawesome-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
        {!! HTML::style('css/template.css') !!}
        @yield('css')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav mr-auto">
                            <li class="mx-3"><input type="text" placeholder="Rechercher"></li>
                            <li class="mx-3"><a href="#" class="nav-link">Streams en cours</a></li>
                        </ul>
    
                        <!-- Right Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li class="mx-3 d-none d-lg-block"><a href="#" class="nav-link">Mes chaines suivies</a></li>
                                <li class="mx-3">
                                    <a href="#" class="d-flex align-start nav-link p-0">
                                        <i class="d-none far fa-envelope fa-2x text-dark"></i>
                                        <i class="fas fa-envelope fa-2x text-dark"></i>
                                        <span class="h-50 badge badge-pill badge-danger">5</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->pseudo }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('home.index') }}" class="dropdown-item">Mon compte</a>
                                        <a href="#" class="dropdown-item">Mes abonnements</a>
                                        <a href="#" class="dropdown-item">Mon stream</a>
                                        <hr>
                                        <a href="#" class="dropdown-item">Administration</a>
                                        <hr>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')

        <footer>

        </footer>
        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-3.3.1.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {!! HTML::script('js/template.js') !!}
        
        @yield('js')
    </body>
</html>