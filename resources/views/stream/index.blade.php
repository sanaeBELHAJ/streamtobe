@extends('layouts.template')

@section('content')
    <div class="container top bottom">
        
        
        
        <div>
            Filtre
            {{ Form::text('q', '', ['class' =>  'form-control searchUser', 'data-action' => 'redirect', 'placeholder' =>  'Rechercher un stream'])}}
        </div>
	<div class="row mt-5">
	   <div class="col-12">
		@if(session()->has('ok'))
		    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
                    @if(count($streams) > 0)
                       <div class="row text-center text-lg-left">
                            @foreach ($streams as $stream)
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <a href="#" class="">
                                       <img class="img-fluid img-thumbnail" src="http://placehold.it/400x300" alt="">
                                       <!--<img class="img-fluid img-thumbnail" src="<?php //echo asset('storage/'.$stream->user->avatar); ?>" alt="" title="Image de profil">-->
                                    </a>
                                   <strong>{!! $stream->user->pseudo !!}</strong>
                                    @if($stream->status==1)
                                        {!! link_to_route('stream.show', 'En ligne', [$stream->user->pseudo], ['class' => 'btn btn-success btn-block']) !!}
                                    @else
                                        {!! link_to_route('stream.show', 'Hors ligne', [$stream->user->pseudo], ['class' => 'btn btn-secondary btn-block']) !!}
                                    @endif
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

@section('css')
<style>
	.table td{
		vertical-align: middle;
	}

	.pictureAccount{
		width: 10%;
	}
</style>
@endsection