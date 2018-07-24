<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php if(strpos(Request::root(), "localhost") === false): ?>
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <?php endif; ?>
        <meta name="google-site-verification" content="{{setting('site.google_analytics_tracking_id')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ setting('site.title') }}</title>
        <meta name="description" content="{{setting('site.description')}}">
        <link rel="icon" href="<?php echo asset('storage/'); ?>/{{setting('site.logo')}}" />

        <!-- CSS -->
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
        {!! Html::style('jquery-ui-1.12.1/jquery-ui.css') !!}
        {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('css/half-slider.css') !!}
        {!! HTML::style('css/font-awesome.min.css') !!}
        {!! HTML::style('css/custom.css') !!}
        {!! HTML::style('css/theme.min.css') !!}
        {!! HTML::style('css/owl.carousel.min.css') !!}
        {!! HTML::style('css/style.css') !!}
        {!! HTML::style('css/normalize.css') !!}
        {!! HTML::style('css/template.css') !!}
        @yield('css')
        @if(env('APP_ENV') == "production" && isset($_COOKIE['valid_cookie']))
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-65526992-2"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-65526992-2');
            </script>

            <!-- Hotjar Tracking Code for www.streamtobe.com -->
            <script>
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:946123,hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
            </script>
        @endif
    </head>
    <body class="fixed-header">
    <header id="header">
        <div class="container" style="margin-left: 0;
    max-width: 100%!important;">
            <div class="navbar-backdrop">
                <div class="navbar">
                    <div class="navbar-left">
                        <a class="navbar-toggle"><i class="fa fa-bars"></i></a>
                        <a href="{{ url('/') }}" style="float:left;margin-right: 25px;padding: 18px 0;"><img class="pictureAccountTemplate" style="background-image:url(<?php echo asset('storage/'); ?>/{{setting('site.logo')}})"></a>
                        <nav class="nav">
                            <ul>
                                <li class="hidden-xs-down  hidden-sm-down hidden-md-down ">
                                    <a href="{{ route('stream.index') }}">{{ __('Streams') }}</a>
                                </li>
                                <li class="hidden-xl-up  hidden-lg-up">
                                    <a href="{{ route('stream.index') }}">{{ __('Streams') }}</a>
                                </li>
                                @guest
                                    <li class="hidden-xl-up  hidden-lg-up">
                                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @endguest
                                @auth
                                    <li class="hidden-xl-up  hidden-lg-up">
                                        <a href="{{ route('home.show',['pseudo' => Auth::user()->pseudo]) }}" class="">Mon profil</a>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up">
                                        <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="">{{ __('My stream') }}</a>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up ">
                                        <a href="/messages" class="">
                                            Message
                                        </a>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up">
                                        <a href="{{ route('home.follows',['pseudo' => Auth::user()->pseudo]) }}">Suivi</a>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up">
                                        <a  href="{{ route('home.fans',['pseudo' => Auth::user()->pseudo]) }}">Fans</a>
                                    </li>
                                    <li class="hidden-xl-up hidden-lg-up">
                                        <a  href="{{ route('home.stats', ['pseudo' => Auth::user()->pseudo]) }}"> Revenus</a>
                                    </li>
                                    <li class="hidden-xl-up hidden-lg-up">
                                        <a  href="{{ route('home.index') }}">{{ __('Settings') }}</a>
                                    </li>

                                    <li class="hidden-xl-up  hidden-lg-up">
                                            @if(Auth::user()->role_id == 1)
                                                <a href="{{ route('voyager.login') }}" class="">{{ __('Administration') }}</a>
                                            @endif
                                        </li>
                                        <li class="hidden-xl-up  hidden-lg-up">
                                            <a class="" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                        <li class="hidden-xl-up  hidden-lg-up">
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                @endauth
                                <li class="hidden-xs-down  hidden-sm-down hidden-md-down ">
                                    <a data-toggle="search">Recherche</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <nav class="nav navbar-right">
                        <ul>
                            @guest
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                                    <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="">{{ __('My stream') }}</a>
                                </li>
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                                    <a href="/messages">
                                        <i class="fa fa-envelope">
                                        </i>
                                        Message
                                    </a>
                                </li>
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down dropdown dropdown-profile" >
                                    <a data-toggle="dropdown">
                                        <img class="pictureAccountTemplate" style="background-image:url(<?php echo asset('storage/'.Auth::user()->avatar); ?>)">
                                        <span data-pseudo="{{ Auth::user()->pseudo }}">{{ Auth::user()->pseudo }}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('home.show',['pseudo' => Auth::user()->pseudo]) }}"><i class="fa fa-user"></i>Mon profil</a>
                                        <a class="dropdown-item" href="{{ route('home.follows',['pseudo' => Auth::user()->pseudo]) }}">
                                            <i class="fa fa-window-restore"></i> Les chaines suivies
                                        </a>
                                        <a class="dropdown-item" href="{{ route('home.fans',['pseudo' => Auth::user()->pseudo]) }}">
                                            <i class="fa fa-users"></i> Mes fans
                                        </a>
                                        <a class="dropdown-item" href="{{ route('home.stats', ['pseudo' => Auth::user()->pseudo]) }}">
                                            <i class="fa fa-dollar"></i> 
                                            Revenus</a>
                                        <a class="dropdown-item" href="{{ route('home.index') }}"><i class="fa fa-cog"></i> {{ __('Settings') }}</a>
                                        <div class="dropdown-divider"></div>
                                        @if(Auth::user()->role_id == 1)
                                            <a href="{{ route('voyager.login') }}" class="dropdown-item">
                                                <i class="fa fa-unlock-alt"></i>{{ __('Administration') }}
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i>   {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                            <li class="hidden-xl-up  hidden-lg-up">
                                <a data-toggle="search"><i class="material-icons" style="vertical-align: middle;">search</i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="navbar-search">
            <div class="container">
                {{ Form::text('q', '', [ 'class' =>  'searchUser form-control', 'data-action' => 'redirect', 'placeholder' =>  'Rechercher un stream'])}}
            </div>
        </div>
    </header>

        @yield('content')


    <!-- Footer -->
    <footer id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 text-center mb-2">
                    <div class="input-group">
                        <button class="btn btn-primary btn-rounded btn-shadow btn-lg mx-auto" type="button" data-toggle="modal" data-target="#supportModal">
                            <span class="text-light">Contactez-nous</span>
                        </button>
                        @include('layouts.modal.contact')
                    </div>
                </div>
                <div class="col-12 col-md-4 text-center mb-2">
                    <p>{{ __('Copyright') }} &copy; {{ setting('site.title') }} 2018</p><a href="/cgu">Conditions générales d'utilisation</a>
                </div>
                <div class="col-12 col-md-4 mb-2 d-flex flex-column justify-content-center">
                    <div class="footer-social">
                        <a href="{{ setting('site.socials-fb') }}"  data-toggle="tooltip" title="facebook"><i class="fa fa-facebook"></i></a>
                        <a  href="{{ setting('site.socials-twitter') }}"  data-toggle="tooltip" title="twitter"><i class="fa fa-twitter"></i></a>
                        <a  href="{{ setting('site.socials-insta') }}"  data-toggle="tooltip" title="instagram"><i class="fa fa-instagram"></i></a>
                    </div>    
                </div>
            </div>
            {{-- <div class="footer-bottom">
                <div class="footer-social">
                    <a href="{{ setting('site.socials-fb') }}"  data-toggle="tooltip" title="facebook"><i class="fa fa-facebook"></i></a>
                    <a  href="{{ setting('site.socials-twitter') }}"  data-toggle="tooltip" title="twitter"><i class="fa fa-twitter"></i></a>
                    <a  href="{{ setting('site.socials-insta') }}"  data-toggle="tooltip" title="instagram"><i class="fa fa-instagram"></i></a>
                </div>
                <p>{{ __('Copyright') }} &copy; {{ setting('site.title') }} 2018</p><a href="/cgu">Conditions générales d'utilisation</a>
            </div> --}}
            @if(!isset($_COOKIE['valid_cookie']))
                <div id="cookies">
                    <div style="margin-top: 15px;">En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies afin d'améliorer son fonctionnement.</div>
                    <button style="margin-bottom: 15px;" class="btn btn-primary btn-rounded" id="valid_cookie"> J'accepte </button>
                </div>
            @endif
        </div>
    </footer>

        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-2.2.4.min.js') !!}
        {!! HTML::script('jquery-ui-1.12.1/jquery-ui.min.js') !!}
        {!! HTML::script('bootstrap/js/popper.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {!! HTML::script('js/owl.carousel.min.js') !!}
        {{-- {!! HTML::script('bootstrap/js/bootstrap.bundle.min.js') !!} --}}
        {!! HTML::script('js/template.js') !!}
        {!! HTML::script('js/theme.min.js') !!}

    <script>
        (function($) {
            "use strict";

            // Full Width Carousel
            $('.owl-slide').owlCarousel({
                nav: true,
                loop: true,
                autoplay: true,
                items: 1
            });

            // Recent Reviews
            $('.owl-list').owlCarousel({
                margin: 25,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 2
                    },
                    701: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

        })(jQuery);
    </script>
        @yield('js')
    </body>
</html>