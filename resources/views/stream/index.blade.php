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
                        <option value="">Toutes les catégories</option>
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
                    <button type="submit" class="btn btn-primary btn-rounded btn-shadow btn-lg  btn-filter">
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
                        <div class="col-6 col-sm-4 col-md-3">
                            <div class="card card-lg">
                                <div class="card-img">
                                    <a href="/home/{{$stream->user->pseudo}}"><img  src="<?php echo asset('storage/' . $stream->user->avatar); ?>" class="card-img-top"></a>
                                        <div class="badge badge-xbox-one">En ligne</div>
                                        <div class="badge badge-ps4" style="left:150px;">{{$stream->type->name}}</div>
                                    <div class="card-likes">
                                        <a href="#"><img src="{{ $stream->user->country->svg }}" style="max-width: 200px;max-height: 30px;"></a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <h4 class="card-title"><a href="/home/{{$stream->user->pseudo}}">{{$stream->user->pseudo}}</a></h4>
                                    <div class="card-meta"><span>Inscrit le {{ Carbon\Carbon::parse($stream->created_at)->format('d/m/Y') }}</span></div>
                                    <p class="card-text">{{$stream->title}}</p>
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
    @if(count($streams) > 0)
    <div class="pagination-results m-t-0" style="text-align: center;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection


