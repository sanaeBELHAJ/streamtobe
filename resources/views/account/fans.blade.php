@extends('layouts.template')

@section('content')
<div class="container-fluid top-2 bottom">
    <div class="row">
        <p class="col-12">Utilisateurs qui suivent la chaine de {{ $streamer->pseudo }}</p>
        <hr>
        @foreach($viewers as $viewer)
            @if($viewer->user->id != $streamer->id && $viewer->user->status > 0)
                <div class='col-6 col-sm-4 col-md-3'>
                    <div class="div-f w-100">
                        <p class="d-flex w-100 justify-content-between align-items-center">
                            <img class='pictureAccount' src="<?php echo asset('storage/' . $viewer->user->avatar); ?>">
                            <a class="" href="/home/{{$viewer->user->pseudo}}">{{$viewer->user->pseudo}}</a>
                        </p>
                        <div class="d-flex w-100 justify-content-between">
                            <p>Inscrit le {{ Carbon\Carbon::parse($viewer->created_att)->format('d/m/Y') }}</p>
                            <p><img src="{{ $viewer->user->country->svg }}" style="max-width: 200px;max-height: 30px;"></p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection