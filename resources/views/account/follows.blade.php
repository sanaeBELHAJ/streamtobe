@extends('layouts.template')

@section('content')
<div class="container-fluid top-2 bottom">
<div class="row">
        <p class="col-12">Chaînes suivies par {{$streamer->pseudo}} :</p>
        <hr>
        @if(count($channels) > 0)
            @foreach($channels as $channel)
                {{-- Chaines des autres streamers suivies par l'utilisateur --}}
                @if($channel->is_follower == 1 && $channel->stream->user->id != $channel->user->id && $channel->stream->user->status > 0)
                    <div class="col-6 col-sm-4 col-md-3">
                    <div class="card card-lg">
                        <div class="card-img">
                            <a href="/home/{{$channel->stream->user->pseudo}}"><img  src="<?php echo asset('storage/' . $channel->stream->user->avatar); ?>" class="card-img-top"></a>
                            @if ($channel->stream->status == 1)
                            <div class="badge badge-xbox-one">En ligne</div>
                                <div class="badge badge-skype" style="left:150px;">{{$channel->stream->type->name}}</div>
                            @else
                            <div class="badge badge-steam">Hors ligne</div>
                            @endif
                            <div class="card-likes">
                                <a href="#"><img src="{{ $channel->stream->user->country->svg }}" style="max-width: 200px;max-height: 30px;"></a>
                            </div>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="/home/{{$channel->stream->user->pseudo}}">{{$channel->stream->user->pseudo}}</a></h4>
                            <div class="card-meta"><span>Inscrit le {{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}</span></div>
                            <p class="card-text">{{$channel->stream->title}}</p>
                        </div>
                    </div>
                </div>

            @endif
            @endforeach
        @else
            <i>Aucune chaine de stream suivie pour l'instant.</i>
        @endif
    </div>
    @if(count($channels) > 0)
    <div class="pagination-results m-t-0" style="display: flex;">
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