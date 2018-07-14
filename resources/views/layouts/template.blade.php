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
        <link rel="icon" href="<?php echo asset('storage/'); ?>/{{setting('site.logo')}}" />

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
    </head>
    <body>
        <header style="font-size:13px">
            <nav style="padding-top:0px;padding-bottom:0px; " class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class=" container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="pictureAccountTemplate" src="<?php echo asset('storage/'); ?>/{{setting('site.logo')}}">
                        <span class="logo-text">{{ setting('site.title') }}</span>
                    </a>
                    <button class="navbar-toggler pull-right" type="button" data-toggle="collapse" 
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav mr-auto">
                            <li class="mx-3">
                                <a href="{{ route('stream.index') }}" class="nav-link">{{ __('Streams') }}</a>
                            </li>
                        </ul>
    

                        <ul class="d-flex justify-content-around  navbar-nav ml-auto">
                             <li class="mx-3 d-flex align-items-center">
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
                                <li><a class="nav-link btn_register" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="nav-link btn_register" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li class="mx-3 d-flex align-items-center">
                                    <a href="/messages" class="d-flex align-start nav-link p-0">
                                        <i class="material-icons">
                                        mail_outline
                                        </i>      
                                        {{-- <i class="fas fa-envelope fa-2x text-white"></i>
                                        <span class="h-50 badge badge-pill badge-danger">5</span> --}}
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                                        {{ Auth::user()->pseudo }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="dropdown-item">{{ __('My stream') }}</a>
                                        <a href="{{ route('home.index') }}" class="dropdown-item">{{ __('Settings') }}</a>
                                        <hr>
                                        @if(Auth::user()->role_id == 1)
                                            <a href="{{ route('voyager.login') }}" class="dropdown-item">{{ __('Administration') }}</a>
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
                                                <p>Votre adresse email afin qu'on puisse vous répondre : <input type="email" name="exped" required="required"></p>
                                            </label>
                                            @endguest
                                        <textarea class="w-100 small" name="opinion" required="required"
                                            placeholder="Un suivi sera établi afin de vous fournir les renseignements les plus pertinents possible."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Envoyer le message</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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