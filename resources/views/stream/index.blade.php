@extends('layouts.template')

@section('content')
    <div class="container top bottom">
        
        
        
        <div class="row">
            <form class="pull-right form-inline" method="POST" action="{{ route('stream.index') }}">
                                        @csrf

                <input type="hidden" id="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name">Titre : </label>
                        <input id="email"  type="text" class="form-control" name="name">
                    </div>
                     <div class="form-group">
                        <label for="categorie">Catégories : </label>
                        <select name="theme" id="stream_type" data-config="type" class="form-control">
                            @foreach($themes as $theme)
                                    @foreach($theme->types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                            @endforeach
                        </select>        
                    </div>
                    <div class="form-group">
                            <label for="countries">Pays : </label>
                                <select name="country" id="stream_type"  data-config="type" class="form-control">
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>        
                    </div>
                     <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                chercher
                            </button>
                    </div>
           </form>
        </div>
	<div class="row mt-5">
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
@endsection


