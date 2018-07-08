<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if(strpos(Request::root(), "localhost") === false): ?>
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <?php endif; ?>
        <meta name="google-site-verification" content="{{setting('site.google_analytics_tracking_id')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ setting('site.title') }}</title>
        <meta name="description" content="{{setting('site.description')}}">
        <link rel="icon" href="<?php echo asset('img/logo1.jpg'); ?>" />

        <!-- CSS -->
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        {!! Html::style('jquery-ui-1.12.1/jquery-ui.css') !!}
        {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('css/half-slider.css') !!}
        {!! HTML::style('fontawesome-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
        {!! HTML::style('css/template.css') !!}
        {!! HTML::style('css/style.css') !!}
        {!! HTML::style('css/normalize.css') !!}
        @yield('css')
        <style>
            #cookies{
                position: fixed;
                width: 100%;
                display: flex;
                justify-content: space-around;
                color: white;
                font-weight: bold;
                margin: 0 auto;
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                padding: 13px 0;
                background-color: cornflowerblue;
                bottom: 20px;
            }

            ul.ui-autocomplete{
                z-index: 1050;
            }
            
            footer #support_user textarea{
                height: 100px;
            }
        </style>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-65526992-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-65526992-2');
        </script>
    </head>
    <body>
        <header style="font-size:13px">
            <nav style="padding-top:0px;padding-bottom:0px; " class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="pictureAccountTemplate" src="<?php echo asset('img/logo1.jpg'); ?>">
                        <span class="logo-text">{{ setting('site.title') }}</span>
                    </a>
                    <button class="navbar-toggler pull-right btn-nav" type="button" data-toggle="collapse"  
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </header>

        <div id="mySidenav" class="sidenav top">
            <a href="javascript:void(0)" class="closebtn btn-nav">&times;</a>
            <ul class="p-0">
                <li class="">
                    <a href="{{ route('stream.index') }}" class="nav-link">{{ __('Streams') }}</a>
                </li>
                <li class=" d-flex align-items-center">
                    <div class="search">
                        <button type="submit">
                            <i class="material-icons">
                                search
                            </i>
                        </button>
                        {{ Form::text('q', '', [ 'class' =>  'searchUser', 'data-action' => 'redirect', 'placeholder' =>  'Rechercher un stream'])}}
                    </div>
                </li>
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    <li class="mx-3 d-flex align-items-center">
                        <a href="/messages" class="d-flex align-start nav-link p-0">
                            <i class="material-icons">mail_outline</i>      
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                            {{ Auth::user()->pseudo }} <span class="caret"></span>
                        </a>

                        <ul>
                            <li><a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">{{ __('My stream') }}</a></li>
                            <li><a href="{{ route('home.index') }}">{{ __('Settings') }}</a></li>
                            <hr>

                            @if(Auth::user()->role_id == 1)
                                <li><a href="{{ route('voyager.login') }}">{{ __('Administration') }}</a></li>
                                <hr>
                            @endif
                            
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>

        @yield('content')


        <!-- Footer -->
        <footer class="py-5 bg-dark mt-auto">
            <div class="container">
                <p class="m-0 pb-1 text-center text-white">{{ __('Copyright') }} &copy; {{ setting('site.title') }} 2018</p>
                @if(!isset($_COOKIE['valid_cookie']))
                    <div id="cookies">
                        <span>En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies afin d'améliorer son fonctionnement.</span> 
                        <button class="btn btn-warning" id="valid_cookie"> J'accepte </button>
                    </div>
                @endif

                <div class="text-center">
                    {{-- @auth --}}
                        <small class="mt-4">
                            <a href="#" class="text-light" data-toggle="modal" data-target="#supportModal"><u>Contactez-nous</u></a>
                        </small>
                        
                        <div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form id="support_user" action="" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="supportModalLabel">Support utilisateur</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <p class="mt-2 alert alert-success d-none" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                Message correctement envoyé.
                                            </p>
                                            <p class="mt-2 alert alert-danger d-none" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                Echec de l'envoi du message
                                            </p>
                                            <p>Bonjour @auth {{ Auth::user()->pseudo }} @endauth</p>
                                            <p>Une question ? Une remarque ?</p>
                                            <p>Donnez-nous notre avis et nous vous répondrons dans les meilleurs délais !</p>
                                            @guest 
                                                <label>
                                                    <p>Votre adresse email : <input type="email" name="exped" required="required"></p>
                                                </label>
                                             @endguest
                                            <textarea class="w-100 small" name="opinion" required="required"
                                                placeholder="Un suivi sera établi afin de vous fournir les renseignements les plus pertinents possible."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Envoyer le message</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    {{-- @endauth --}}
                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-2.2.4.min.js') !!}
        {!! HTML::script('jquery-ui-1.12.1/jquery-ui.min.js') !!}
        {!! HTML::script('bootstrap/js/popper.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {{-- {!! HTML::script('bootstrap/js/bootstrap.bundle.min.js') !!} --}}
        {!! HTML::script('js/template.js') !!}
        
        @yield('js')
    </body>
</html>