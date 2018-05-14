<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="{{setting('site.google_analytics_tracking_id')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title')</title>
        
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <!-- css 
  <link href="https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic,700|Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/bootstrap-responsive.css" rel="stylesheet" />
  <link href="css/fancybox/jquery.fancybox.css" rel="stylesheet">
  <link href="css/jcarousel.css" rel="stylesheet" />
  <link href="css/flexslider.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <!-- Theme skin
  <link href="skins/default.css" rel="stylesheet" />-->
  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png" />
  <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png" />
  <link rel="shortcut icon" href="ico/favicon.png" />
  {!! Html::style('css/bootstrap.css') !!}
  {!! Html::style('css/bootstrap-responsive.css') !!}
  {!! Html::style('css/fancybox/jquery.fancybox.css') !!}
  {!! Html::style('css/jcarousel.css') !!}
  {!! Html::style('css/flexslider.css') !!}
  {!! Html::style('css/style.css') !!}
  {!! Html::style('skins/default.css') !!}
      
    </head>
    <body>
        <div id="wrapper">
            
            <!-- toggle top area -->
            <div class="hidden-top">
              <div class="hidden-top-inner container">
                <div class="row">
                  <div class="span12">
                    <ul>
                      <li><strong>Stremtobe le monde de talent sans limite</strong></li>
                      <li>ESGI</li>
                      <li>Tel: <i class="icon-phone"></i> (123) 456-7890 - (123) 555-7891</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <header>
      <div class="container ">
        <!-- hidden top area toggle link -->
        <div id="header-hidden-link">
          <a href="#" class="toggle-link" title="Click me you'll get a surprise" data-target=".hidden-top"><i></i>Open</a>
        </div>
        <div class="row nomargin">
          <div class="span12">
            <div class="span4">
                <div class="logo">
                    <center><a href="{{ url('/') }}">{{ HTML::image('img/logo.png', 'a picture') }}Streamtobe</a></center>
                </div>
            </div>
            <div class="headnav">
              <ul>
                    @guest
                <li><a href="{{ route('register') }}" data-toggle="modal"><i class="icon-user"></i> Enregistrer</a></li>
                <li><a href="{{ route('login') }}" data-toggle="modal">Se connecter</a></li>
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
        </div>
        <div class="row">
          <div class="span4">
           
          </div>
          <div class="span8">
            <div class="navbar navbar-static-top">
              <div class="navigation">
                <nav>
                  <ul class="nav topnav">
                    <li class=" active">
                      <a href="index.html">Streams en cours</a>
                    </li>
                    <li>
                      <a href="contact.html">Contact </a>
                    </li>
                  </ul>
                </nav>
              </div>
      </div>
            <!--<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="pictureAccountTemplate" src="<?php echo asset('storage/'.setting('site.logo')); ?>">
                        {{ setting('site.title') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar 
                        <ul class="d-flex justify-content-around  navbar-nav mr-auto">
                            <li class="mx-3 d-flex align-items-center">
                                {{ Form::open(['method' => 'GET', 'route' => ['autocomplete'], 'id' => 'search_user']) }}
                                    {{ Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Rechercher un stream'])}}
                                {{ Form::close() }}
                            </li>
                            <li class="mx-3"><a href="{{ route('stream.index') }}" class="nav-link">Streams actifs</a></li>
                        </ul>
    
                        <!-- Right Side Of Navbar 
                        <ul class="d-flex justify-content-around  navbar-nav ml-auto">
                            <!-- Authentication Links 
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
            </nav>-->
        </header>
        <div class="">
            @yield('content')
        </div>
        </div>
        <footer>
      <div class="container">
        <div class="row">
          <div class="span3">
            <div class="widget">
              <h5 class="widgetheading">Browse pages</h5>
              <ul class="link-list">
                <li><a href="#">About our company</a></li>
                <li><a href="#">Our services</a></li>
                <li><a href="#">Meet our team</a></li>
                <li><a href="#">Explore our portfolio</a></li>
                <li><a href="#">Get in touch with us</a></li>
              </ul>
            </div>
          </div>
          <div class="span3">
            <div class="widget">
              <h5 class="widgetheading">Important stuff</h5>
              <ul class="link-list">
                <li><a href="#">Press release</a></li>
                <li><a href="#">Terms and conditions</a></li>
                <li><a href="#">Privacy policy</a></li>
                <li><a href="#">Career center</a></li>
                <li><a href="#">Flattern forum</a></li>
              </ul>
            </div>
          </div>
          <div class="span3">
            <div class="widget">
              <h5 class="widgetheading">Flickr photostream</h5>
              <div class="flickr_badge">
                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=8&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=34178660@N03"></script>
              </div>
              <div class="clear">
              </div>
            </div>
          </div>
          <div class="span3">
            <div class="widget">
              <h5 class="widgetheading">Get in touch with us</h5>
              <address>
								<strong>Flattern studio, Pte Ltd</strong><br>
								 Springville center X264, Park Ave S.01<br>
								 Semarang 16425 Indonesia
					 		</address>
              <p>
                <i class="icon-phone"></i> (123) 456-7890 - (123) 555-7891 <br>
                <i class="icon-envelope-alt"></i> email@domainname.com
              </p>
            </div>
          </div>
        </div>
      </div>
      <div id="sub-footer">
        <div class="container">
          <div class="row">
            <div class="span6">
              <div class="copyright">
                <p>
                  <span>&copy; Flattern - All right reserved.</span>
                </p>
                <div class="credits">
                  <!--
                    All the links in the footer should remain intact.
                    You can delete the links only if you purchased the pro version.
                    Licensing information: https://bootstrapmade.com/license/
                    Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Flattern
                  -->
                  Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
              </div>
            </div>
            <div class="span6">
              <ul class="social-network">
                <li><a href="#" data-placement="bottom" title="Facebook"><i class="icon-facebook icon-square"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Twitter"><i class="icon-twitter icon-square"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Linkedin"><i class="icon-linkedin icon-square"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Pinterest"><i class="icon-pinterest icon-square"></i></a></li>
                <li><a href="#" data-placement="bottom" title="Google plus"><i class="icon-google-plus icon-square"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    {!! Html::SCRIPT('js/jquery.js') !!}
    {!! Html::SCRIPT('js/jquery.easing.1.3.js') !!}
    {!! Html::SCRIPT('js/bootstrap.js') !!}
    {!! Html::SCRIPT('js/jcarousel/jquery.jcarousel.min.js') !!}
    {!! Html::SCRIPT('js/jquery.fancybox.pack.js') !!}
    {!! Html::SCRIPT('js/jquery.fancybox-media.js') !!}
    {!! Html::SCRIPT('js/google-code-prettify/prettify.js') !!}
    {!! Html::SCRIPT('js/portfolio/jquery.quicksand.js') !!}
    {!! Html::SCRIPT('js/portfolio/setting.js') !!}
    {!! Html::SCRIPT('js/jquery.flexslider.js') !!}
    {!! Html::SCRIPT('js/jquery.nivo.slider.js') !!}
    {!! Html::SCRIPT('js/modernizr.custom.js') !!}
    {!! Html::SCRIPT('js/jquery.ba-cond.min.js') !!}
    {!! Html::SCRIPT('js/jquery.slitslider.js') !!}
    {!! Html::SCRIPT('js/animate.js') !!}
    {!! Html::SCRIPT('js/custom.js') !!}

        </footer>
        <!-- JAVASCRIPT -->
      
       
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