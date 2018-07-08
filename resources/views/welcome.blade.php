@extends('layouts.template')

@section('content')
<div class="container-fluid @guest p-0 @endguest">
    @auth

    <div class="row">
        <div class="col-sm-2 profil-panel">
            <div class="top bottom">
                <a href="{{ route('home.index') }}" class="right" style="margin-top: 0px;"> 
                   <i class="material-icons">
                    edit
                   </i>
                </a>
                <br>
                <div class="cadre-style">
                    <center>
                        <img class="resize-img" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                    </center> 
                </div>
                <p>
                    <center>{{ Auth::user()->pseudo }}</center>
                    <center>
                        <i class="material-icons" style="font-size: 16px;">location_on</i>
                        @if(Auth::user()->country){{ Auth::user()->country->name }}@endif
                        <img style="width:10%" src="@if(Auth::user()->country){{ Auth::user()->country->svg }}@endif">
                    </center>
                </p>
                 <center>
                    <ul class="navbar-nav">
                        <li  class="nav-item">
                            <a class="text-white" href="{{ route('home.follows', ['pseudo' =>  Auth::user()->pseudo ])}}">Suivi</a>
                        </li>
                        <li  class="nav-item">
                            <a class="text-white"  href="{{ route('home.fans', ['pseudo' =>  Auth::user()->pseudo ])}}">Fans</a>
                        </li>
                        <li  class="nav-item">
                            <a class="text-white"  href="{{ route('home.stats', ['pseudo' =>  Auth::user()->pseudo ]) }}">Revenus</a>
                        </li>
                    </ul>
                    <br>
                    <a class="machaine" href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">                  
                        <i style="font-size: 50px;margin-top: 10px" class="material-icons">
                            videocam
                        </i>
                    </a>
                </center>
            </div>
        </div>
        <div class="col-sm-10 pull-right bottom" style="margin-top: 50px;">
            <p> Les chaines que vous suivez :</p>
            <hr>
                            <div class="col-12">
        @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
        @endif
                    @if(count($streams) > 0)
                    <div class="row text-center text-lg-left">
                            @foreach ($streams as $stream)
                                <div class="col-lg-3 col-md-4 col-xs-6" style="box-sizing: border-box;">
                                    <a href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                    <!--<img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">-->
                                    <span class="watch"><i class="material-icons gold-text" style="color:#f4eb19f0">settings_input_antenna</i>  <i class="material-icons">remove_red_eye</i>   123</span>
                                    @if($stream->user->avatar!="users/default.png")
                                            <img class="img-fluid img-thumbnail" src="<?php echo asset('storage/'.$stream->user->avatar); ?>" alt="" title="Image de profil">
                                    @else
                                            <img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">
                                    @endif
                                    </a>
                                    @if($stream->status==1)
                                        {!! link_to_route('stream.show', $stream->user->pseudo, [$stream->user->pseudo], ['class' => 'pull-right']) !!}
                                    @else
                                        {!! link_to_route('stream.show', $stream->user->pseudo, [$stream->user->pseudo], ['class' => 'pull-right']) !!}
                                    @endif
                                    <img style="width:10%" src="@if(Auth::user()->country){{ Auth::user()->country->svg }}@endif">
                                </div>
                            @endforeach
                    </div>
            @else
                <i>Vous ne suivez actuellement aucun stream.</i>
            @endif
        </div>
        </div>
    </div>



    @else
        <header>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">

                    @foreach($listSlider as $picture)
                        <li data-target="#carouselExampleIndicators" 
                            data-slide-to="{{$loop->index}}" 
                            @if($loop->first) class="active" @endif></li>
                    @endforeach

                </ol>
                <div class="carousel-inner" role="listbox">

                    @foreach($listSlider as $picture)

                        <div class="carousel-item @if ($loop->first) active @endif" style="background-image: url('{{$picture}}')">
                            <div class="carousel-caption d-none d-sm-block ">
                                <div class="visible">
                                    <h3>{{setting('site.image-'.$loop->index)}}</h3>
                                    <p>{{ __("Let's show your skill on your stream") }}</p>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    
                    {{--<div class="carousel-item active" style="background-image: url('img/kitchen-ready-for-cooking_4460x4460.jpg')">
                        <div class="carousel-caption d-none d-sm-block ">
                            <div class="visible">
                                <h3>Vous aimez la cuisine!</h3>
                                <p>Venez montrer vos talents chef sur votre chaine.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" style="background-image: url('img/woman-playing-guitar_4460x4460.jpg')">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="visible">
                                <h3>Vous aimez chanter? Vous savez jouer sur un instrument musical!</h3>
                                <p>Vous pouvez vous montrer en public!</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" style="background-image: url('img/casual-and-creative-at-home_4460x4460.jpg')">
                        <div class="carousel-caption d-none d-md-block">
                            <div class="visible">
                                <h3>Quelque soit vos talents! Votre place est chez nous!</h3>
                                <p>Chaine, fun, amis...</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row btn-slider">
                    <a href="{{ route('stream.index') }}"  class="btn btn-lg gold mt-4">{{ __('Watch our current streams') }}</a>
                    <a href="{{ route('register') }}"  class="btn btn-lg gold mt-4">{{ __('Create your own stream') }}</a>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <section class="py-5">
        <div class="container">
            {{-- Streamtobe est là pour vous ! --}}
            <h1>{{ setting('site.welcome-title') }}</h1>
            {{-- Si vous avez du talent et vous n'avez pas peur de la caméra, créez votre chaine et montrez-vous ! On vous attend ! --}}
            <p>{{ setting('site.welcome-text') }}</p>
        </div>
        </section>
    @endauth


</div>
@endsection

@section('css')
<style>
    .carousel-caption{
        bottom: 50%;
        transform: translateY(50%);
    }
    .btn-slider{
        display:flex;
        width:50%;
        justify-content: space-around;
        position: absolute;
        bottom: 15%;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
@endsection