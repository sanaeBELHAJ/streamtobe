@extends('layouts.template')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12 pull-right top-2 bottom">
        <p>Chaines suivies par {{$streamer->pseudo}}</p>
        <hr>
        <br>
        @if(count($channels) > 0)
            @foreach($channels as $channel)
                {{-- Chaines des autres streamers suivies par l'utilisateur --}}
                @if($channel->is_follower == 1 && $channel->stream->user->id != $channel->user->id && $channel->stream->user->status > 0)
                    <div class='col-6 div-f'>
                        <img class='avatar_follower' src="<?php echo asset('storage/' . $channel->stream->user->avatar); ?>">
                        <a class="" href="/home/{{$channel->stream->user->pseudo}}">{{$channel->stream->user->pseudo}}</a>
                        {{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}
                        <span class="anciennete" data-date="{{$channel->created_at}}"></span>
                        @auth
                            <button class="btn btn-follow" id="abo" href="#">S'abonner</button>
                        @endauth
                    </div>
                @endif
            @endforeach
        @else
            <i>Aucune chaine de stream suivie pour l'instant.</i>
        @endif
    </div>
</div>
</div>
@endsection