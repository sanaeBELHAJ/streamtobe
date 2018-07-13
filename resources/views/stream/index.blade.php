@extends('layouts.template')

@section('content')
<div class="container top bottom">
    <div class="row">
        <div class=" col-sm-12 div-filter">
            <form class="pull-right form-inline" method="POST" action="{{ route('stream.index') }}">
                @csrf
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="form-group mb-2">
                    <label for="name">Titre  </label>
                    <input id="email"  type="text" class="form-control" name="name">
                </div>
                <div class="form-group mb-2">
                    <label for="categorie">Catégories  </label>
                    <select name="theme" id="stream_type" data-config="type" class="form-control">
                        <option> Séléctionner une catégorie</option>
                        @foreach($themes as $theme)
                            <optgroup label="{{$theme->name}}">
                                @foreach($theme->types as $type)
                                    <option value="{{$type->name}}">{{$type->name}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="countries">Pays </label>
                    <select name="country" id="stream_type"  data-config="type" class="form-control">
                        <option> Séléctionner un pays</option>
                        @if($countries)
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        @endif
                    </select>        
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary btn-filter">
                        chercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            @auth
                @if(count($streams) > 0)
                    <div class="row text-center text-lg-left">
                        @foreach ($streams as $stream)
                        <div class="col-lg-3 col-md-4 col-xs-6" style="box-sizing: border-box;">
                            <a href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                <!--<img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">-->
                                <span class="watch"><i class="material-icons gold-text" style="color:#f4eb19f0">settings_input_antenna</i>  <i class="material-icons">remove_red_eye</i>   123</span>
                                @if($stream->user->avatar!="users/default.png")
                                <img class="img-fluid img-thumbnail" src="<?php echo asset('storage/' . $stream->user->avatar); ?>" alt="" title="Image de profil">
                                @else
                                <img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">
                                @endif
                            </a>
                            <div class="row">
                                <div class="col-sm-6">
                                    @if($stream->status==1)
                                    <a class="broadcastname pull-right"  href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                            {{ $stream->user->pseudo}}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <img class="right" style="width:20%; padding-top: 4px" src="@auth @if(Auth::user()->country){{ Auth::user()->country->svg }}@endif @endauth">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <i>Vous ne suivez actuellement aucun stream.</i>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection


