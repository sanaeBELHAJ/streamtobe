@extends('layouts.template')

@section('content')
@auth

<div class="row">
        <div class="col-sm-3 gold">
            <div class="top bottom">
                <a href="{{ route('home.index') }}" class="right" style="margin-top: 0px;"> 
                    <i class="far fa-edit text-white"></i>
                </a>
                <br>
                <div class="cadre-style">
                    <center>
                        <img class="resize-img" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                    </center> 
                </div>
                <center>{{ Auth::user()->pseudo }}</center>
                <center>{{ Auth::user()->country->name }}</center>
                <center>
                    <ul class="navbar-nav">
                        <li  class="nav-item"><a class="text-white"  href="#">Mes abonnés</a></li>
                        <li  class="nav-item"><a class="text-white"  href="#">Mes revenus</a></li>
                        <li  class="nav-item"><a class="text-white"  href="#">Mes activités</a></li>
                    </ul>
                    <a class="machaine active" href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">Ma chaine                    
                                        <i class="far fa-play-circle text-white"></i>
                    </a>

                </center>
            </div>
        </div>
        <div class="col-sm-9 pull-right top bottom">
                             les stream les plus populaires actives: 
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
                                    <img style="width:10%" src="{{ Auth::user()->country->svg }}">
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
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active" style="background-image: url('img/kitchen-ready-for-cooking_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block ">
                <div class="visible">
                     <h3>Vous aimez la cuisine!</h3>
                     <p>Venez montrer vos talents chef sur votre chaine.</p>
                </div>
              <a href="{{ route('stream.index') }}"  class="btn btn-lg gold">Regarder nos chaines </a>
              <a href="{{ route('register') }}"  class="btn  btn-lg gold">Créer votre chaine</a>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url('img/woman-playing-guitar_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <div class="visible">
                <h3>Vous aimez chanter? Vous savez jouer sur un instrument musical!</h3>
                <p>Vous pouvez vous montrer en public!</p>
              </div>
              <a href="{{ route('stream.index') }}"  class="btn  btn-lg gold">Regarder nos chaines </a>
              <a href="{{ route('register') }}"  class="btn  btn-lg gold">Créer votre chaine</a>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url('img/casual-and-creative-at-home_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block">
                <div class="visible">
                    <h3>Quelque soit vos talents! Votre place est chez nous!</h3>
                    <p>Chaine, fun, amis...</p>
                </div>
              <a href="{{ route('stream.index') }}"  class="btn  btn-lg gold">Regarder nos chaines </a>
              <a href="{{ route('register') }}"  class="btn  btn-lg gold">Créer votre chaine</a>
            </div>
          </div>
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
        <h1>Streamtobe est là pour vous!</h1>
        <p>Si vous avez du talents et vous n'avez pas peur de caméra, créez votre chaine et montrez vous! On vous attend :p
      </div>
    </section>
@endauth






@endsection
