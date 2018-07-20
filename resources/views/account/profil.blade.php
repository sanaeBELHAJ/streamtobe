@extends('layouts.template')

@section('content')
<div class="container bottom">
    <h1 class="text-center">Profil de {{ $streamer->pseudo }}</h1>
    <h3 class="text-left">Informations</h3>
    <div class="row">
            <div class="col-6">
                <img class="pictureAccount" style="background-image:url(<?php echo asset('storage/' . $streamer->avatar); ?>)">
            </div>
            <div class="col-6 d-flex flex-row-reverse">
                <div class="row">
                    <div class="col-12">
                        @auth
                            @php ($IsCurrentViewer = 0)
                            @foreach(Auth::user()->viewers as $viewer)
                            @if($streamer->stream->id == $viewer->stream_id)
                            <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 1) @else d-none @endif"
                                    data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                    title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner <i class="fa fa-unlink"></i></button>
                            <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 0) @else d-none @endif"
                                    data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                    title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner <i class="fa fa-heart-o"></i></button>
                            @php ($IsCurrentViewer = 1)
                            @endif
                            @endforeach
                            @if($IsCurrentViewer == 0)
                            <button class="follow_stream w-100 float-none btn btn-follow d-none"
                                    data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                    title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner <i class="fa fa-unlink"></i></button>
                            <button class="follow_stream w-100 float-none btn btn-follow"
                                    data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                    title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner <i class="fa fa-heart-o"></i></button>
                            @endif
                        @endauth
                        <div class="col-12">
                            <p>Compte créé le: <?php echo date('d/m/Y', strtotime($streamer->created_at)); ?></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h3>La chaine de streaming</h3>
        <div class="row">
            <p class="col-12">Pays : <img src="{{ $streamer->country->svg }}" style="max-width: 200px;max-height: 30px;"></p>

            <p class="col-12">{{ $streamer->pseudo }} est actuellement : <?php echo ($streamer->stream->status == 0) ? "<span class='badge badge-steam'>Hors-ligne</span>" : "   <span class='badge badge-xbox-one'>En ligne</span>"; ?>.</p>
            @if($streamer->stream->status==0 && $streamer->stream->updated_at)
            <p class="col-12">Sa dernière diffusion remonte à <?php echo date('d/m/Y', strtotime($streamer->stream->updated_at)); ?></p>
            @endif

            <p class="col-6 d-flex align-items-center">Vous pouvez accèder à sa chaine en cliquant directement sur la caméra : </p>
            <p class="col-6 position-relative">
                <a class="" href="{{ route('stream.show', ['user' => $streamer->pseudo]) }}">
                    <i class="fa fa-camera fa-5x">
                    </i>
                </a>
            </p>


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
            <a class="btn btn-facebook btn-lg btn-rounded m-l-10" href="/follows/{{$streamer->pseudo}}">Ses followers  <i class="fa fa-user"></i></a>
            <a class="btn btn-danger btn-lg btn-rounded m-l-10" href="/fans/{{$streamer->pseudo}}">Ses chaînes <i class="fa fa-heart"></i></a>
            @if(Auth::check() && $streamer->pseudo == Auth::user()->pseudo)
            <a class="btn btn-primary btn-lg btn-rounded m-l-10" href="/stats/{{$streamer->pseudo}}">Dons <i class="fa fa-dollar"></i></a>
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