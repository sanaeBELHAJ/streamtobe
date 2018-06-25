<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="{{setting('site.google_analytics_tracking_id')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ setting('site.title') }}</title>
        <meta name="description" content="{{setting('site.description')}}">
        <link rel="icon" href="<?php echo asset('storage/'.setting('site.favicon')); ?>" />

        <!-- CSS -->
        {!! Html::style('jquery-ui-1.12.1/jquery-ui.css') !!}
        {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
        {!! HTML::style('fontawesome-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
        {!! HTML::style('css/template.css') !!}
        {!! HTML::style('css/style.css') !!}
        {!! HTML::style('css/normalize.css') !!}
        {!! HTML::style('css/font-awesome.min.css') !!}
        @yield('css')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.setting('site.logo')); ?>">
                        {{ setting('site.title') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav mr-auto">
                            <li class="mx-3 d-flex align-items-center">
                                {{ Form::open(['method' => 'GET', 'route' => ['autocomplete'], 'id' => 'search_user']) }}
                                    {{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Rechercher un stream'])}}
                                {{ Form::close() }}
                            </li>
                            <li class="mx-3"><a href="{{ route('stream.index') }}" class="nav-link">Streams actifs</a></li>
                        </ul>
    
                        <!-- Right Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li class="mx-3 d-flex align-items-center">
                                    <a href="#" class="d-flex align-start nav-link p-0">
                                        <i class="d-none far fa-envelope fa-2x text-dark"></i>
                                        <i class="fas fa-envelope fa-2x text-dark"></i>
                                        <span class="h-50 badge badge-pill badge-danger">5</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                                        {{ Auth::user()->pseudo }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('home.index') }}" class="dropdown-item">Mon compte</a>
                                        <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="dropdown-item">Mon stream</a>
                                        <hr>
                                        @if(Auth::user()->role_id == 1)
                                            <a href="{{ route('voyager.login') }}" class="dropdown-item">Administration</a>
                                            <hr>
                                        @endif
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
        {!! HTML::script('jquery-ui-1.12.1/jquery-ui.min.js') !!}
        {!! HTML::script('bootstrap/js/popper.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {!! HTML::script('js/template.js') !!}
        <script>
            $(function () {
                //CSRF Protection
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('[data-toggle="tooltip"]').tooltip();

                $('#search_user').submit(function(event){
                    event.preventDefault();
                    return false;
                });

                $( "#q" ).autocomplete({
                    source: "/autocomplete",
                    minLength: 2,
                    select: function(event, ui) {
                        $('#q').val(ui.item.value);
                        window.location.replace("/stream/"+ui.item.value);
                    }
                })
                .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                        .data( "ui-autocomplete-item", item )
                        .append("<img class='results_picture' src='"+item.avatar+"'> "+item.value )
                        .appendTo( ul );
                };
            });
        </script>
        @yield('js')
    </body>
</html>