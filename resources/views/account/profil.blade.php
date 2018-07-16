@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 pull-right top-1 bottom">
            <hr>
            <div class="row d-flex flex-row-reverse">
                @auth
                    <div class='col-sm-3'>
                        @foreach(Auth::user()->viewers as $viewer)
                            @if($streamer->stream->id == $viewer->stream_id)
                                <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 1) @else d-none @endif" 
                                        data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                        title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner</button>
                                <button class="follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 0) @else d-none @endif" 
                                        data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                        title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner</button>
                            @endif
                        @endforeach
                    </div>
                @endauth
            </div>
            <div class='col-sm-12'>
                <hr>
            </div>
            <div class="col-sm-12">
                @if($streamer->stream->status == 1)
                    <p>{{ $streamer->pseudo }} est actuellement en direct, vous pouvez rejoindre sa chaine.</p>
                @else
                    <p>{{ $streamer->pseudo }} n'est pas en ligne pour l'instant.</p>
                @endif
                <div class="col-sm-12">
                    <center>
                        <a class="machaine active" href="{{ route('stream.show', ['user' => $streamer->pseudo]) }}">                  
                            <i style="font-size: 50px;margin-top: 10px" class="material-icons">
                                play_circle_filled
                            </i>
                        </a>
                    </center>
                </div>
            </div> 
        </div>
        </div>
    </div>
</div>
    @endsection