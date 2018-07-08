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
                        <img class="resize-img" src="<?php echo asset('storage/'.$streamer->avatar); ?>" alt="Image de profil" title="Image de profil">
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
                    <a class="machaine active" href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">                  
                        <i style="font-size: 50px;margin-top: 10px" class="material-icons">
                            videocam
                        </i>
                    </a>
                </center>
            </div>
    </div>
    <div class="col-sm-10 pull-right top bottom">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Mes chaines suivies</th>
                </tr>
                <tr>
                    <th>Image</th>
                    <th>Chaîne</th>
                    <th>Ancienneté</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @if(count($channels) > 0)
                    @foreach($channels as $channel)
                        @if($channel->is_follower == 1)
                            <tr>
                                <td>
                                    <img class="avatar_follower" src="<?php echo asset('storage/'.$channel->stream->user->avatar); ?>" 
                                        alt="" title="Image de profil">
                                </td>
                                <td>{{$channel->stream->user->pseudo}}</td>
                                <td>{{ Carbon\Carbon::parse($channel->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if($channel->stream->status==1)
                                        {!! link_to_route('stream.show',
                                                            'En ligne', 
                                                            [$channel->stream->user->pseudo], 
                                                            ['class' => 'btn btn-success btn-block']) !!}
                                    @else
                                        {!! link_to_route('stream.show', 
                                                            'Hors ligne', 
                                                            [$channel->stream->user->pseudo], 
                                                            ['class' => 'btn btn-secondary btn-block']) !!}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">
                            <i>Vous n'avez consulté aucune chaine de stream pour l'instant.</i>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection