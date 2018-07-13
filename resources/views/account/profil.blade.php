@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2  profil-panel">
            <div class="top bottom">
                @if( Auth::user()->pseudo == $streamer->pseudo)
                <a href="{{ route('home.index') }}" class="right" style="margin-top: 0px;"> 
                    <i class="material-icons">
                        edit
                    </i>
                </a>
                @endif
                <br>
                <div class="cadre-style">
                    <center>
                        <img class="resize-img" src="<?php echo asset('storage/' . $streamer->avatar); ?>" alt="Image de profil" title="Image de profil">
                    </center> 
                </div>
                <p>
                <center>{{ $streamer->pseudo }}</center>
                <center>
                    @if($streamer->country != null)
                    <i class="material-icons" style="font-size: 16px;">location_on</i>{{ $streamer->country->name }}
                    <img style="width:10%" src="{{ $streamer->country->svg }}">
                    @else
                    <i class="material-icons" style="font-size: 16px;">location_on</i>
                    Inconnu
                    @endif
                </center>
                </p>
                <center>
                    <ul class="navbar-nav">
                        <li  class="nav-item">
                            <a class="text-white"  href="{{ route('home.follows',['pseudo' => $streamer->pseudo]) }}">Suivi</a>
                        </li>
                        <li  class="nav-item">
                            <a class="text-white"  href="{{ route('home.fans',['pseudo' => $streamer->pseudo]) }}">Fans</a>
                        </li>
                        <li  class="nav-item">
                            <a class="text-white"  href="{{ route('home.stats', ['pseudo' => $streamer->pseudo]) }}">Revenus</a>
                        </li>
                    </ul>
                    <br>

                    <a class="btn-contacter" href="/messages">                  
                      Contacter
                    </a>
                </center>
            </div>

        </div>
        <div class="col-sm-10 pull-right top-1 bottom">
            <hr>
            <div class="row">
                 <div class='col-sm-12'>
                @foreach($user->viewers as $viewer)
                @if($streamer->stream->id == $viewer->stream_id)
                @if($viewer->is_follower == 1)
                <center>
                    <button class="btn btn-follow" id="abo" href="#">S'abonner</button>
                </center>
                <center>
                    <button class="btn btn-follow" id="desabo" href="#" disabled>Désabonner</button>
                </center>
                @break
                @endif

                @if($loop->last)
                <center>
                    <button class="btn btn-follow" id="abo" href="#" disabled>S'abonner</button>
                </center>
                <center>
                    <button class="btn btn-follow" id="desabo" href="#">Désabonner</button>
                </center>
                @endif
                @endif
                @endforeach
            </div>
            <div class='col-sm-12'>
            <hr>
            </div>
            <div class="col-sm-12">

                <p>{{ $streamer->pseudo }} est actuellement en direct, vous pouvez rejoindre sa chaine.</p>
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

    @section('js')	
    <script>
        $(function () {
            /* Buttons stream (viewer) */
            function followingStream() {
                var following = ($(this).is("#abo")) ? 1 : 0;
                var stream = "{{$streamer->pseudo}}";

                $.ajax({
                    url: "/followStream",
                    type: 'POST',
                    data: {
                        stream: stream,
                        is_following: following
                    }
                })
                        .done(function (data) {
                            $(".btn-follow").prop('disabled', function (i, v) {
                                return !v;
                            });
                        })
                        .fail(function (data) {
                            console.log(data);
                        });
            }
            $(".btn-follow").click(followingStream);
        });
    </script>
    @endsection