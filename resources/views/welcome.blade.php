@extends('layouts.template')

@section('content')
    <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active" style="background-image: url('img/kitchen-ready-for-cooking_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Vous aimez la cuisine!</h3>
              <p>Venez montrer vos talents chef sur votre chaine.</p>
              <a href="{{ route('stream.index') }}"  class="btn btn-lg gold">Regarder nos chaines </a>
              <a href="{{ route('register') }}"  class="btn  btn-lg gold">Créer votre chaine</a>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url('img/woman-playing-guitar_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Vous aimez chanter? Vous savez jouer sur un instrument musical!</h3>
              <p>Vous pouvez vous montrer en public!</p>
              <a href="{{ route('stream.index') }}"  class="btn  btn-lg gold">Regarder nos chaines </a>
              <a href="{{ route('register') }}"  class="btn  btn-lg gold">Créer votre chaine</a>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url('img/casual-and-creative-at-home_4460x4460.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3>Quelque soit vos talents! Votre place est chez nous!</h3>
              <p>Chaine, fun, amis...</p>
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







@endsection
