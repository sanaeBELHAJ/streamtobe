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
        <link rel="icon" href="<?php echo asset('img/logo1.jpg'); ?>" />

        <!-- CSS -->
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        {!! Html::style('jquery-ui-1.12.1/jquery-ui.css') !!}
        {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('css/half-slider.css') !!}
        {!! HTML::style('fontawesome-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
        {!! HTML::style('css/template.css') !!}
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

            footer #support_user textarea{
                height: 100px;
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="pictureAccountTemplate" src="<?php echo asset('img/logo1.jpg'); ?>">
                        <!--{{ setting('site.title') }}-->
                        <span style="  font-family: BaskervilleAmpersand, Helvetica, Arial, Serif;">StreamToBe</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav mr-auto">
                            <li class="mx-3 d-flex align-items-center">
                                {{ Form::text('q', '', ['class' =>  'form-control searchUser', 'data-action' => 'redirect', 'placeholder' =>  'Rechercher un stream'])}}
                            </li>
                            <li class="mx-3">
                                <a href="{{ route('stream.index') }}" class="nav-link">Streams actifs</a>
                            </li>
                        </ul>
    
                        <!-- Right Side Of Navbar -->
                        <ul class="d-flex justify-content-around  navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @else
                                <li class="mx-3 d-flex align-items-center">
                                    <a href="/messages" class="d-flex align-start nav-link p-0">
                                        <i class="far fa-envelope fa-1x text-white"></i>
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
                                        <a href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}" class="dropdown-item">Mon stream</a>
                                        <a href="{{ route('home.index') }}" class="dropdown-item">Paramètres</a>
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


        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                {{-- @include('layouts.footer')   --}}
                <p class="m-0 text-center text-white">Copyright &copy; StreamToBe 2018</p>
            </div>
        <!-- /.container -->
        </footer>

        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-3.3.1.min.js') !!}
        {!! HTML::script('jquery-ui-1.12.1/jquery-ui.min.js') !!}
        {!! HTML::script('bootstrap/js/popper.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.bundle.min.js') !!}
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

                //Recherche d'utilisateurs
                $(".searchUser").each(function(){
                    $(this).autocomplete({
                        source: "/autocomplete",
                        minLength: 2,
                        select: function(event, ui) {
                            $(this).val(ui.item.value);
                            var action = $(this).data('action');
    
                            if(action == "redirect")
                                window.location.replace("/stream/"+ui.item.value);
                            else if(action == "ban" || action == "mod")
                                statusViewer(ui.item.value, action, 1); //Fonction appelée dans stream.show
                        }
                    })
                    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                        return $( "<li></li>" )
                            .data( "ui-autocomplete-item", item )
                            .append("<img class='results_picture' src='"+item.avatar+"'> "+item.value )
                            .appendTo( ul );
                    };
                });
                
                //Edit modération/bannissement
                function statusViewer(pseudo, rank, set){
                    $.ajax({
                        url: "/updateViewer",
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            pseudo: pseudo,
                            rank: rank,
                            set: set
                        }
                    })
                    .done(function(data){
                        updateList();
                        $(".searchUser").val("");
                    })
                    .fail(function(data){
                        console.log(data);
                    });
                }
                
                //Detection du click() sur les boutons générés par les appels Ajax
                if($("#config_stream").length > 0){
                    $("#config_stream").on("click", ".rmvRankUser", function(){
                        var action = $(this).data('action');
                        var pseudo = $(this).data('pseudo');
                        statusViewer(pseudo, action, 0);
                    });
                }

                //Liste modérateurs / bannis
                updateList();
                function updateList(){
                    $.ajax({
                        url: "/getStreamViewer",
                        type: 'GET'
                    })
                    .done(function(data){
                        $("#listMods").html('');
                        $("#listBans").html('');
                        $.each(data, function(index, element){
                            var text = "";
                            text +='<tr class="d-flex justify-content-between">';
                                text += '<td>'+element.pseudo+'</td>';

                                if(element.rank == 1)
                                    text += "<td><button data-action='mod' data-pseudo='"+element.pseudo+"' ";
                                else if(element.rank == -1)
                                    text += "<td><button data-action='ban' data-pseudo='"+element.pseudo+"' ";

                                text += "class='rmvRankUser btn btn-primary'>Retirer</button></td>"; 
                            text += "</tr>";

                            if(element.rank == 1)
                                $("#listMods").append(text);
                            else if(element.rank == -1)
                                $("#listBans").append(text);
                        });
                    })
                    .fail(function(data){
                        console.log(data);
                    });
                }

                //Validation cookie
                $('#valid_cookie').click(function(){
                    $.ajax({
                        url: "/valid_cookie",
                        type: 'POST'
                    })
                    .done(function(data){
                        $("#cookies").hide();
                    })
                    .fail(function(data){
                        console.log(data);
                    });
                });

                //Support utilisateur
                $('#support_user').submit(function(event){
                    event.preventDefault();
                    $.ajax({
                        url: "/support",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            opinion: $("[name='opinion']").val()
                        }
                    })
                    .done(function(data){
                        $("[name='opinion']").val('');
                        $("#support_user .alert-success").removeClass('d-none').addClass('d-block');
                        $("#support_user .alert-danger").removeClass('d-block').addClass('d-none');
                    })
                    .fail(function(data){
                        $("#support_user .alert-success").removeClass('d-block').addClass('d-none');
                        $("#support_user .alert-danger").removeClass('d-none').addClass('d-block');
                        console.log(data);
                    });
                    return false;
                });
            });
        </script>
        @yield('js')
    </body>
</html>