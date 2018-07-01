@extends('layouts.template')

@section('content')
<div class="container-fluid">
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