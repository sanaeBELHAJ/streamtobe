@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-sm-3 gold">
            <div class="top bottom">
                <a href="{{ route('home.index') }}" class="right" style="margin-top: 0px;"> 
                    <i class="far fa-edit text-white"></i>
                </a>
                <br>
                <div class="cadre-style">
                    <center>
                        <img class="resize-img" src="<?php echo asset('storage/'.Auth::user()->avatar); ?>" alt="Image de profil" title="Image de profil">
                    </center> 
                </div>
                <p>
                    <center>{{ Auth::user()->pseudo }}</center>
                    <center>
                        <i class="material-icons" style="font-size: 16px;">location_on</i>
                        @if(Auth::user()->country){{ Auth::user()->country->name }}@endif
                        <img style="width:10%" src="@if(Auth::user()->country){{ Auth::user()->country->svg }}@endif">
                    </center>
                </p>
                <center>
                    <ul class="navbar-nav">
                        <li  class="nav-item"><a class="text-white"  href="#">Mes abonnés</a></li>
                        <li  class="nav-item"><a class="text-white"  href="#">Mes revenus</a></li>
                        <li  class="nav-item"><a class="text-white"  href="#">Mes activités</a></li>
                    </ul>
                    <a class="machaine active" href="{{ route('stream.show', ['user' => Auth::user()->pseudo]) }}">Ma chaine                    
                                        <i class="far fa-play-circle text-white"></i>
                    </a>

                </center>
            </div>
    </div>
    <div class="col-sm-9 pull-right top bottom">
        <table>
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
@endsection