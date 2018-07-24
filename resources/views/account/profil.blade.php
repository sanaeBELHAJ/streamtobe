@extends('layouts.template')

@section('content')
<div class="container-fluid profil">
    <div class="row">
<div class="col-lg-12 col-sm-12">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="<?php echo asset('storage/'.$streamer->avatar); ?>">
            <!-- http://lorempixel.com/850/280/people/9/ -->
        </div>
        <div class="useravatar">
            <img alt="" src="<?php echo asset('storage/'.$streamer->avatar); ?>">
        </div>
        <div class="card-info"> 
            <span class="card-title">{{ $streamer->pseudo }}</span>
        </div>
    </div>
    <div class="" role="group" aria-label="...">
       <ul class="nav nav-tabs" role="tablist">
           
            <li class="nav-item">
              <a class="nav-link active" href="#profile" role="tab" data-toggle="tab"><i class="fa fa-user"></i>A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#machaine" role="tab" data-toggle="tab"><i class="fa fa-window-restore"></i>Ses chaînes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#follows" role="tab" data-toggle="tab"><i class="fa fa-heart"></i>Ses fans</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#revenus" role="tab" data-toggle="tab"><i class="fa fa-dollar"></i>Revenus </a>
            </li>
            <div class="col-sm-4"></div>
            <div class="col-sm-2">
              @php ($IsCurrentViewer = 0)
                @foreach(Auth::user()->viewers as $viewer)
                    @if($streamer->stream->id == $viewer->stream_id)
                        <button class="col-sm-12 pull-right right follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 1) @else d-none @endif"
                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner <i class="fa fa-unlink"></i></button>
                        <button class="col-sm-12 pull-right right  follow_stream w-100 float-none btn btn-follow @if($viewer->is_follower == 0) @else d-none @endif"
                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner <i class="fa fa-heart-o"></i></button>
                        @php ($IsCurrentViewer = 1)
                    @endif
                @endforeach
            </div>
        </ul>

<!-- Tab panes --> 
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade show active cardinfo card-lg" id="profile">
        <div class="row">
            <div class="col-sm-12 card-block">
                <p class="col-12">Membre depuis le <?php echo date('d/m/Y', strtotime($streamer->created_at)); ?></p>
                <p class="col-12">Pays : <img src="{{ $streamer->country->svg }}" style="max-width: 200px;max-height: 30px;"></p>

                <p class="col-12">{{ $streamer->pseudo }} est actuellement : <?php echo ($streamer->stream->status==0) ? "<span class='badge badge-steam'>Hors-ligne</span>" : "   <span class='badge badge-xbox-one'>En ligne</span>"; ?>.</p>
                @if($streamer->stream->status==0 && $streamer->stream->updated_at)
                    <p class="col-12">Sa dernière diffusion remonte à <?php echo date('d/m/Y', strtotime($streamer->stream->updated_at)); ?></p>
                @endif

                <p class="col-6 d-flex align-items-center">Vous pouvez accèder à sa chaine en cliquant directement sur la caméra : </p>
                <p class="col-6 position-relative">
                    <a class="" href="{{ route('stream.show', ['user' => $streamer->pseudo]) }}">
                        <i class="fa fa-camera fa-5x">
                        </i>
                    </a>
                </p>
            </div>
        </div>
    </div>
  <div role="tabpanel" class="tab-pane fade" id="machaine">bbb</div>
  <div role="tabpanel" class="tab-pane fade" id="follows">ccc</div>
  <div role="tabpanel" class="tab-pane fade" id="revenus">ccc</div>
</div>
 
    </div>
    </div>
    
</div>  
</div>
@endsection


    @section('css')
    <style>
        .btn_stream{
            font-size: 50px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
        .cardinfo{
            background-color: #fff;
            border: 1px solid #dedede;
            -webkit-box-shadow: 0 1px 2px 0 rgba(0,0,0,0.07);
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.07);
            margin-bottom: 30px;
            border-radius: 6px;
        }
    </style>
    @endsection