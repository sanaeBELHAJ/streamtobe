@extends('layouts.template')

@section('content')
<div class="container-fluid top-2 bottom">
    <div class="row">
        <p class="col-12">Utilisateurs qui suivent la chaine de {{ $streamer->pseudo }}</p>
        <hr>
        @foreach($streamer->stream->viewers as $viewer)
            @if($viewer->is_follower==1 && $viewer->user->id != $streamer->id && $viewer->user->status > 0)
                <div class=" col-sm-6 col-lg-3 col-md-5">
                    <div class="card card-lg">
                        <div class="card-img">
                            <a href="/home/{{$viewer->user->pseudo}}">
                                <span class=" card-img-top w-100 d-block" style="height: 200px;background-size: cover;background-position: center;background-image:url(<?php echo asset('storage/' . $viewer->user->avatar); ?>)"></span>
                                @if ($viewer->user->stream->status == 1)
                                    <div class="badge badge-xbox-one">En ligne</div>
                                    <div class="badge badge-ps4" style="left:150px;">{{$viewer->user->stream->type->name}}</div>
                                @else
                                    <div class="badge badge-steam">Hors ligne</div>
                                @endif
                                <div class="card-likes">
                                    <img src="{{ $viewer->user->country->svg }}" style="max-width: 200px;max-height: 30px;">
                                </div>
                            </a>
                        </div>
                        <div class="card-block">
                            <h4 class="card-title"><a href="/home/{{$viewer->user->pseudo}}">{{$viewer->user->pseudo}}</a></h4>
                            <div class="card-meta"><span>Inscrit le {{ Carbon\Carbon::parse($viewer->user->created_at)->format('d/m/Y') }}</span></div>
                            <p class="card-text">{{$viewer->user->stream->title}}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    @if($viewer->is_follower==1 && $viewer->user->id != $streamer->id && $viewer->user->status > 0)
    <div class="pagination-results m-t-0" style="text-align: center;">
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