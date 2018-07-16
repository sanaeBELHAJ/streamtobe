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
            <section class="bg-inverse p-y-0">
                <div class="owl-carousel owl-slide full-height">
                    @foreach($listSlider as $picture)
                    <div class="carousel-item" style="background-image: url('{{$picture}}')">
                        <div class="carousel-overlay"></div>
                        <div class="carousel-caption">
                            <div>
                                <h3 class="carousel-title">{{setting('site.image-'.$loop->index)}}</h3>
                                <p>{{ __("Let's show your skill on your stream") }}</p>
                                <a class="btn btn-primary btn-rounded btn-shadow btn-lg" href="{{ route('stream.index') }}" data-lightbox role="button">{{ __('Watch our current streams') }}</a>
                                <a class="btn btn-primary btn-rounded btn-shadow btn-lg" href="{{ route('register') }}" data-lightbox role="button">{{ __('Create your own stream') }}</a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        </header>

        <!-- Page Content -->
        <section class="py-5">
        <div class="container-fluid" style="text-align: center">
            {{-- Streamtobe est là pour vous ! --}}
            <h1>{{ setting('site.welcome-title') }}</h1>
            <p>{{ setting('site.welcome-text') }}</p>
            <div class="row" style="margin-top:100px;">
            {{-- Si vous avez du talent et vous n'avez pas peur de la caméra, créez votre chaine et montrez-vous ! On vous attend ! --}}
                <div class="col-sm-12 col-md-4"><br/>
                    <a class="btn btn-primary btn-rounded btn-shadow btn-lg" href="{{ route('register') }}" data-lightbox role="button">{{ __('Create your own stream') }}</a><br/><br/>
                    Creez votre compte ! Pour cela, rien de plus simple, rejoignez-nous en 1 click !
                </div>
                <div class="col-sm-12 col-md-4">
                    <i class="fa fa-camera fa-5x" aria-hidden="true"></i><br/><br/>
                    Lancez votre propre chaine ou suivez vos streamers favoris !
                </div>
                <div class="col-sm-12 col-md-4">
                    <i class="fa fa-dollar fa-5x" aria-hidden="true"></i><br/><br/>
                    Encouragez vos streamers favoris en leur faisant une donation ou bien recoltez vos propres revenus !
                </div>
            </div>
        </div>
        </section>
    @endauth


</div>
@endsection