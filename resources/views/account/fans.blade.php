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
                    @if( Auth::user()->pseudo == $streamer->pseudo)
                        <a class="machaine active" href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">                  
                            <i style="font-size: 50px;margin-top: 10px" class="material-icons">
                                videocam
                            </i>
                        </a>
                    @endif
                </center>
            </div>
    </div>
    <div class="col-sm-10 pull-right top bottom">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">Utilisateurs qui me suivent</th>
                <tr>
                    <th>Image</th>
                    <th>Pseudo</th>
                    <th>Ancienneté</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewers as $viewer)
                    <tr>
                        <td><img class='avatar_follower' src="<?php echo asset('storage/'.$viewer->user->avatar); ?>"></td>
                        <td>{{$viewer->user->pseudo}}</td>
                        <td>
                            {{ Carbon\Carbon::parse($viewer->created_at)->format('d/m/Y') }}
                            <span class="anciennete" data-date="{{$viewer->created_at}}"></span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
</div>
</div>
@endsection