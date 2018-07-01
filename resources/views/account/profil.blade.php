@extends('layouts.template')

@section('content')
    <style>
   .card {
     box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
     max-width: 300px;
     margin: auto;
     text-align: center;
     font-family: arial;
   }

   .title {
     color: grey;
     font-size: 18px;
   }

   button {
     border: none;
     outline: 0;
     display: inline-block;
     padding: 8px;
     color: white;
     background-color: #4b367c;
     text-align: center;
     cursor: pointer;
     width: 100%;
     font-size: 18px;
   }

   a {
     text-decoration: none;
     font-size: 22px;
     color: black;
   }

   button:hover, a:hover {
     opacity: 0.7;
   }
   </style>

<div class="row">
    <div class="col-sm-3">
           
    </div>
    <div class="col-sm-6 pull-right top bottom">
        <h2 style="text-align:center"></h2>
        <div class="card">
            <div class="cadre-style">
                <center>
                    <img src="<?php echo asset('storage/'.$streamer->avatar); ?>" alt="Image de profil" title="Image de profil" style="width:50%; height: 10%">
                </center> 
            </div>
            <h1>{{ $streamer->pseudo }}</h1>
          <p class="title">{{ $streamer->description }}</p>

          <span>
           <i class="material-icons" style="font-size: 16px;color: purple">location_on</i>{{ $streamer->country->name }}
           <img style="width:10%" src="{{$streamer->country->svg }}">
          </span>
          <div style="margin: 24px 0;">
         </div>
         <p><button>Contacter</button></p>
        </div>
    </div>
    <div class="col-sm-3">
          <i class="far fa-play-circle text-white"></i>
    </div>
</div>
@endsection
