@extends('layouts.template')

@section('content')
<div class="container bottom">
    <h1 class="text-center">Profil de {{ $streamer->pseudo }}</h1>
    <h3 class="text-left">Informations</h3>
    <div class="row">
        <div class="col-6">
            <img class="pictureAccount" src="<?php echo asset('storage/'.$streamer->avatar); ?>">
            <img src="{{ $streamer->country->svg }}" style="max-width: 200px;max-height: 30px;">
        </div>
        <div class="col-6 d-flex flex-row-reverse">
            <p>Compte créé le: <?php echo date('d/m/Y', strtotime($streamer->created_at)); ?></p>
        </div>
    </div>
    <hr>
    <h3>La chaine de streaming</h3>
    <div class="row">
        <p class="col-12">{{ $streamer->pseudo }} est actuellement <?php echo ($streamer->stream->status==0) ? "<span class='text-danger'>hors-ligne</span>" : "<span class='text-success'>en cours de diffusion</span>"; ?>.</p>
        @if($streamer->stream->status==0 && $streamer->stream->updated_at)
            <p class="col-12">Sa dernière diffusion remonte à <?php echo date('d/m/Y', strtotime($streamer->stream->updated_at)); ?></p>
        @endif
        
        <p class="col-6 d-flex align-items-center">Vous pouvez accèder à sa chaine en cliquant directement sur l'icône à côté</p>
        <p class="col-6 position-relative">
            <a class="machaine active mx-auto" href="{{ route('stream.show', ['user' => $streamer->pseudo]) }}">                  
                <i class="material-icons btn_stream">
                    play_circle_filled
                </i>
            </a>
        </p>

        @auth
            <div class='offset-6 col-6'>
                @php ($IsCurrentViewer = 0)
                @foreach(Auth::user()->viewers as $viewer)
                    @if($streamer->stream->id == $viewer->stream_id)
                        <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 1) @else d-none @endif"
                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner</button>
                        <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 0) @else d-none @endif"
                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner</button>
                        @php ($IsCurrentViewer = 1)
                    @endif
                @endforeach
                @if($IsCurrentViewer == 0)
                    <button class="follow_stream w-100 float-none btn btn-follow d-none"
                            data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                            title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner</button>
                    <button class="follow_stream w-100 float-none btn btn-follow"
                            data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                            title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner</button>
                @endif
            </div>
        @endauth
    </div>
    <hr>
    <h3>Description de {{ $streamer->pseudo }}</h3>
    <div class="row">
        <p class="col-12">
            @if($streamer->description)
                {{ $streamer->description }} 
            @else 
                Cet utilisateur n'a pas encore rédigé de description
            @endif
        </p>
    </div>
    <hr>
    <h3>Statistiques</h3>
    <div class="row">
        <p class="col-12">Vous pouvez consulter des informations complémentaires à propos de la chaine de {{ $streamer->pseudo }} :</p>
        @if($streamer->pseudo == Auth::user()->pseudo)
            <a class="btn col-12 col-md-4 text-center" href="/follows/{{$streamer->pseudo}}">Les fans de cette chaine</a>
            <a class="btn col-12 col-md-4 text-center" href="/fans/{{$streamer->pseudo}}">Les chaines que {{ $streamer->pseudo }} suit</a>
            <a class="btn col-12 col-md-4 text-center" href="/stats/{{$streamer->pseudo}}">Les dons reçus par {{ $streamer->pseudo }}</a>
        @else
            <a class="btn col-12 col-md-6 text-center" href="/follows/{{$streamer->pseudo}}">Les fans de cette chaine</a>
            <a class="btn col-12 col-md-6 text-center" href="/fans/{{$streamer->pseudo}}">Les chaines que {{ $streamer->pseudo }} suit</a>
        @endif
    </div>
</div>
@endsection

@section('css')
<style>
    .btn_stream{
        font-size: 50px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
@endsection