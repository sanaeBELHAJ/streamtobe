@extends('layouts.template')

@section('content')
<div class="container-fluid @guest p-0 @endguest">
    @auth

    <div class="row">
        <div class="col-sm-12 pull-right bottom" style="margin-top: 50px;">
            <p>Bienvenue {{ Auth::user()->pseudo }},</p>
            <hr>
            <p> Les chaines en live que vous suivez :</p>
            
            <div class="row col-12">
                @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                @endif

                @if(count($followed) > 0)
                    <div class="row text-center text-lg-left">
                        @foreach ($followed as $stream)
                            <div class="col-12 col-sm-6 col-md-4" style="box-sizing: border-box;">
                                <a href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                    <!--<img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">-->
                                    <span class="watch">
                                        <i class="material-icons gold-text" style="color:#f4eb19f0">settings_input_antenna</i>
                                        {{ $stream->type->name }}
                                    </span>
                                    @if($stream->user->avatar!="users/default.png")
                                        <img class="img-fluid img-thumbnail" src="<?php echo asset('storage/'.$stream->user->avatar); ?>" alt="" title="Image de profil">
                                    @else
                                        <img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">
                                    @endif
                                </a>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="broadcastname pull-right"  href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                            {{ $stream->title }}
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small>
                                            <a class="broadcastname pull-right"  href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                                {{ $stream->user->pseudo }}
                                            </a>
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <img class="right" style="width:20%; padding-top: 4px" src="{{ $stream->user->country->svg }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <i>Vous ne suivez actuellement aucun stream.</i>
                @endif
            </div>
            <hr>
            <p>Vos dernières statistiques : </p>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-header">
                            Valeur des dons obtenus ce mois-ci
                        </div>
                        <div class="card-body">
                            <h2 class="card-title">&asymp;{{ $donations }} €</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-header">
                            Nombre total de followers
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><?php echo count($followers); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-header">
                            Nombre total de visiteur
                        </div>
                        <div class="card-body">
                            <h2 class="card-title">{{ $viewers->count() }}</h2>
                        </div>
                    </div>
                </div>
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