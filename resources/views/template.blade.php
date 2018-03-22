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

        </header>
        <div class="container">
            @yield('content')
        </div>
        <footer>

        </footer>
        <!-- JAVASCRIPT -->
        {!! HTML::script('jquery-3.3.1.min.js') !!}
        {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
        {!! HTML::script('js/template.js') !!}
        
        @yield('js')
    </body>
</html>