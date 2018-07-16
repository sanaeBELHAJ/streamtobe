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
        {!! HTML::style('fontawesome-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
        {!! HTML::style('css/template.css') !!}
        {!! HTML::style('css/custom.css') !!}
        {!! HTML::style('css/theme.min.css') !!}
        {!! HTML::style('css/style.css') !!}
        {!! HTML::style('css/normalize.css') !!}
        @yield('css')
        @if(env('APP_ENV') == "production")
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
                        <a href="{{ url('/') }}" style="float:left;margin-right: 25px;padding: 18px 0;"><img class="pictureAccountTemplate" src="<?php echo asset('storage/'); ?>/{{setting('site.logo')}}" alt="Streamtobe"></a>
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
                                        <a href="{{ route('home.index') }}" class="">Profil</a>
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
                                    <li class="hidden-xs-down  hidden-sm-down hidden-md-down "><a data-toggle="search">Recherche</a></li>
                            </ul>
                        </nav>
                    </div>
                    <li class="nav navbar-right">
                            <ul>
                                @guest
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li class="hidden-sm-down hidden-md-down  hidden-xs-down"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @else
                        <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                            <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="">{{ __('My stream') }}</a>
                        </li>
                         <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                             <a href="{{ route('home.follows',['pseudo' => Auth::user()->pseudo]) }}">Suivi</a>
                         </li>
                          <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                              <a  href="{{ route('home.fans',['pseudo' => Auth::user()->pseudo]) }}">Fans</a>
                           </li>
                          <li class="hidden-sm-down hidden-md-down  hidden-xs-down">
                            @if(Auth::user()->role_id == 1)
                                <a href="{{ route('voyager.login') }}" class="">{{ __('Administration') }}</a>
                            @endif
                          </li>
                           <li class="hidden-sm-down hidden-md-down  hidden-xs-down dropdown dropdown-profile" >
                                        <a data-toggle="dropdown">
                                            <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>">
                                            <span  {{ Auth::user()->pseudo }} ></span>
                                        </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                   <a class="dropdown-item" href="{{ route('home.index') }}"><i class="fa fa-user"></i> Profil</a>
                                   <a href="/messages" class="dropdown-item">
                                       <i class="fa fa-envelope-open">
                                       </i>
                                       Message
                                   </a>
                                   <a class="dropdown-item" href="{{ route('home.stats', ['pseudo' => Auth::user()->pseudo]) }}"><i class="fa fa-dollar-sign"></i> Revenus</a>
                                   <div class="dropdown-divider"></div>
                                   <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                       {{ __('Logout') }}
                                   <i class="fa fa-sign-out"></i></a>
                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                       @csrf
                                   </form>
                               </div>
                                    </li>
                                    <li class="hidden-xl-up  hidden-lg-up"><a data-toggle="search"><i class="material-icons" style="vertical-align: middle;">
                                                search
                                            </i></a></li>

                            </ul>
                    </li>
                    @endguest
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
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <h4 class="footer-title">A propos de nous</h4>
                    <p>Nous proposons du streaming</p>

                </div>
                <div class="col-sm-12 col-md-4">
                    <h4 class="footer-title">Nous contacter</h4>
                    <p>Nous sommes disponibles 7/7j</p>
                    <div class="input-group m-t-25">
                     <button class="btn btn-primary" type="button"><a href="#" class="text-light" data-toggle="modal" data-target="#supportModal">Contactez-nous</a></button>
                     </span>
                        <div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true" style="color: black;">
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
            </div>
            <div class="footer-bottom">
                <div class="footer-social">
                    <a href="#"  data-toggle="tooltip" title="facebook"><i class="fa fa-facebook"></i></a>
                    <a  href="#"  data-toggle="tooltip" title="twitter"><i class="fa fa-twitter"></i></a>
                    <a  href="#"  data-toggle="tooltip" title="steam"><i class="fa fa-steam"></i></a>
                    <a  href="#"  data-toggle="tooltip" title="twitch"><i class="fa fa-twitch"></i></a>
                    <a  href="#"  data-toggle="tooltip" title="youtube"><i class="fa fa-youtube"></i></a>
                </div>
                <p>{{ __('Copyright') }} &copy; {{ setting('site.title') }} 2018</p>
            </div>
            @if(!isset($_COOKIE['valid_cookie']))
                <div id="cookies">
                    <span>En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies afin d'améliorer son fonctionnement.</span>
                    <button class="btn btn-warning" id="valid_cookie"> J'accepte </button>
                </div>
            @endif
        </div>
    </footer>

        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-2.2.4.min.js') !!}
        {!! HTML::script('jquery-ui-1.12.1/jquery-ui.min.js') !!}
        {!! HTML::script('bootstrap/js/popper.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {{-- {!! HTML::script('bootstrap/js/bootstrap.bundle.min.js') !!} --}}
        {!! HTML::script('js/template.js') !!}
        {!! HTML::script('js/theme.min.js') !!}
        @yield('js')
    </body>
</html>