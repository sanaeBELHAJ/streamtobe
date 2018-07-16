@extends('layouts.template')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12 pull-right top-2 bottom">
        <p>Utilisateurs qui suivent la chaine de {{$streamer->pseudo}}</p>
        <hr>
        <br>
        @foreach($viewers as $viewer)
            @if($viewer->user->id != $streamer->id && $viewer->user->status > 0)
                <div class='col-6 div-f'>
                    <img class='avatar_follower' src="<?php echo asset('storage/' . $viewer->user->avatar); ?>">
                    <a class=""  href="/home/{{$viewer->user->pseudo}}">{{$viewer->user->pseudo}}</a>
                    {{ Carbon\Carbon::parse($viewer->created_at)->format('d/m/Y') }}
                    <span class="anciennete" data-date="{{$viewer->created_at}}"></span>
                    <button class="btn btn-follow" id="abo" href="#">S'abonner</button>
                </div>
            @endif
        @endforeach
    </div>
</div>
</div>
@endsection