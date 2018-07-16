@extends('layouts.template')

@section('content')
<div class="container-fluid top-2 bottom">
<div class="row">
        <p class="col-12">Chaines suivies par {{$streamer->pseudo}}</p>
        <hr>
        @if(count($channels) > 0)
            @foreach($channels as $channel)
                {{-- Chaines des autres streamers suivies par l'utilisateur --}}
                @if($channel->is_follower == 1 && $channel->stream->user->id != $channel->user->id && $channel->stream->user->status > 0)
                    <div class='col-6 col-sm-4 col-md-3'>
                        <div class="div-f w-100">
                            <p class="d-flex w-100 justify-content-between align-items-center">
                                <a class="" href="/home/{{$channel->stream->user->pseudo}}">
                                    <img class='pictureAccount' src="<?php echo asset('storage/' . $channel->stream->user->avatar); ?>">
                                </a>
                                <a class="" href="/home/{{$channel->stream->user->pseudo}}">{{$channel->stream->user->pseudo}}</a>
                            </p>
                            <div class="d-flex w-100 justify-content-between">
                                <p>Inscrit le {{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}</p>
                                <p><img src="{{ $channel->stream->user->country->svg }}" style="max-width: 200px;max-height: 30px;"></p>
                            </div>
                        </div>
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