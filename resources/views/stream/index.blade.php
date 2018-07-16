@extends('layouts.template')

@section('content')
<div class="container top bottom">
    <div class="row">
        <div class=" col-sm-12 div-filter">
            <form class="pull-right form-inline" method="POST" action="{{ route('stream.index') }}">
                @csrf
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
                <div class="form-group mb-2 d-flex">
                    <label for="name">Titre  </label>
  
                    <input id="email"  type="text" class="form-control" name="name" value="{{ $inputs['name'] }}">
                    {!! $errors->first('name', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
                </div>
                <div class="form-group mb-2 d-flex">
                    <label for="categorie">Catégories  </label>
                    <select name="theme" id="stream_type" data-config="type" class="form-control">
                        <option value="">Toutes les catégorie</option>
                        @foreach($themes as $theme)
                            <optgroup label="{{$theme->name}}">
                                @foreach($theme->types as $type)
                                    <option value="{{$type->id}}" @if($inputs['theme'] == $type->id) selected @endif>{{$type->name}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    {!! $errors->first('theme', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
                </div>
                <div class="form-group mb-2 d-flex">
                    <label for="countries">Pays </label>
                    <select name="country" id="stream_type"  data-config="type" class="form-control">
                        <option value="">Tous les pays</option>
                        @if($countries)
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" @if($inputs['country'] == $country->id) selected @endif>{{$country->name}}</option>
                            @endforeach
                        @endif
                    </select> 
                    {!! $errors->first('country', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}       
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary btn-rounded btn-shadow btn-lg">
                        Rechercher
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

            @if(count($streams) > 0)
                <div class="row text-center text-lg-left">
                    @foreach ($streams as $stream)
                    <div class="col-12 col-6 col-md-3 mb-4" style="box-sizing: border-box;">
                        <a href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                            <!--<img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">-->
                            <span class="watch">
                                <i class="material-icons gold-text" style="color:#f4eb19f0">settings_input_antenna</i>
                                {{ $stream->type->name }}
                            </span>
                            @if($stream->user->avatar!="users/default.png")
                                <img class="img-fluid img-thumbnail" src="<?php echo asset('storage/' . $stream->user->avatar); ?>" alt="" title="Image de profil">
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
                            <div class="col-6">
                                <small>
                                    <a class="broadcastname pull-right"  href="{{ route('stream.show', ['user' => $stream->user->pseudo]) }}" class="item">
                                        {{ $stream->user->pseudo }}
                                    </a>
                                </small>
                            </div>
                            <div class="col-6">
                                <img class="right" style="width:20%; padding-top: 4px" src="{{ $stream->user->country->svg }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <i>Aucun stream n'est actuellement en cours de diffusion.</i>
            @endif
        </div>
    </div>
</div>
@endsection


