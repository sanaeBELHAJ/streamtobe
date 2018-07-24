@extends('layouts.template')

@section('content')
    <div class="container-fluid profil">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card hovercard">
                    <div class="card-background">
                        <img class="card-bkimg" alt="" src="<?php echo asset('storage/' . $streamer->avatar); ?>">
                        <!-- http://lorempixel.com/850/280/people/9/ -->
                    </div>
                    <div class="useravatar">
                        <img alt="" src="<?php echo asset('storage/' . $streamer->avatar); ?>">
                    </div>
                    <div class="card-info">
                        <span class="card-title">{{ $streamer->pseudo }}</span>
                    </div>
                </div>
                <div class="" role="group" aria-label="...">
                    <ul class="nav nav-tabs" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active text-center" href="#profile" role="tab" data-toggle="tab"><i class="fa fa-user"></i>A propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="#machaine" role="tab" data-toggle="tab"><i class="fa fa-window-restore"></i>Ses abonnements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="#fans" role="tab" data-toggle="tab"><i class="fa fa-heart"></i>Ses fans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="#revenus" role="tab" data-toggle="tab"><i class="fa fa-dollar"></i>Revenus </a>
                        </li>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            @auth
                                @php ($IsCurrentViewer = 0)

                                @foreach($streamer->viewers as $viewer)
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
                            @endauth
                        </div>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active cardInfo card-lg" id="profile">
                            <div class="row card-block">
                                <div class="col-sm-12 ">
                                    <p class="col-12">Membre depuis le <?php echo date('d/m/Y', strtotime($streamer->created_at)); ?></p>
                                    <p class="col-12">Pays : <img src="{{ $streamer->country->svg }}" style="max-width: 200px;max-height: 30px;"></p>

                                    <p class="col-12">{{ $streamer->pseudo }} est actuellement : <?php echo ($streamer->stream->status == 0) ? "<span class='badge badge-steam'>Hors-ligne</span>" : "   <span class='badge badge-xbox-one'>En ligne</span>"; ?>.</p>
                                    @if($streamer->stream->status==0 && $streamer->stream->updated_at)
                                        <p class="col-12">Sa dernière diffusion remonte à <?php echo date('d/m/Y', strtotime($streamer->stream->updated_at)); ?></p>
                                    @endif

                                    <p class="col-12">Nombre de chansons interprétées : {{ count($musics) }}</p>
                                    <p class="col-12">Moyenne des notes attribuées par le public : {{ $medium }}%</p>
                                    <p class="col-12">Nombre de chansons proposées par le public : {{ count($gifts) }}</p>
        
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
                        <div role="tabpanel" class="tab-pane fade" id="machaine">
                            @if(count($channels) > 0)
                                <div class="table-container">
                                    <table class="table table-filter">
                                        <tbody>
                                        @foreach($channels as $channel)
                                            {{-- Chaines des autres streamers suivies par l'utilisateur --}}
                                            @if($channel->is_follower == 1 && $channel->stream->user->id != $channel->user->id && $channel->stream->user->status > 0)


                                                <tr data-status="pagado">
                                                    <td>
                                                        <div class="media">
                                                            <a href="/home/{{$channel->stream->user->pseudo}}" class="pull-left">
                                                                <img src="<?php echo asset('storage/' . $channel->stream->user->avatar); ?>" class="media-photo">
                                                            </a>
                                                            <div class="media-body">
                                                                <a href="/home/{{$channel->stream->user->pseudo}}" class="pull-left w-100">
                                                                    <span class="media-meta pull-right">Inscrit le {{ Carbon\Carbon::parse($channel->stream->created_at)->format('d/m/Y') }}</span>
                                                                    <h4 class="title">
                                                                        {{$channel->stream->user->pseudo}}
                                                                        <span class="pull-right pagado">
                                                                            @if ($channel->stream->status == 1)
                                                                                <div class="badge badge-xbox-one">En ligne</div>
                                                                                <div class="badge badge-ps4" style="left:150px;">{{$channel->stream->type->name}}</div>
                                                                            @else
                                                                                <div class="badge badge-steam">Hors ligne</div>
                                                                            @endif
                                                                        </span>
                                                                    </h4>
                                                                    <p class="summary">{{$channel->stream->title}}</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <i>Aucune chaine de stream suivie pour l'instant.</i>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="fans">
                            <div class="table-container">
                                <table class="table table-filter">
                                    <tbody>
                                    @foreach($streamer->stream->viewers as $viewer)
                                        @if($viewer->is_follower==1 && $viewer->user->id != $streamer->id && $viewer->user->status > 0)
                                            <tr data-status="pagado">
                                                <td>
                                                    <div class="media">
                                                        <a href="/home/{{$viewer->user->pseudo}}" class="pull-left">
                                                            <img src="<?php echo asset('storage/' . $viewer->user->avatar); ?>" class="media-photo">
                                                        </a>
                                                        <div class="media-body">
                                                            <span class="media-meta pull-right">Inscrit le {{ Carbon\Carbon::parse($viewer->user->created_at)->format('d/m/Y') }}</span>
                                                            <h4 class="title">
                                                                {{$viewer->user->pseudo}}
                                                                <span class="pull-right pagado">
                                                        @if ($viewer->user->stream->status == 1)
                                                                        <div class="badge badge-xbox-one">En ligne</div>
                                                                        <div class="badge badge-ps4" style="left:150px;">{{$viewer->user->stream->type->name}}</div>
                                                                    @else
                                                                        <div class="badge badge-steam">Hors ligne</div>
                                                                    @endif
                                                        </span>
                                                            </h4>
                                                            <p class="summary">{{$viewer->user->stream->title}}</p>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="revenus">
                            @if(Auth::check() && $streamer->pseudo == Auth::user()->pseudo)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Montant</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($donations) > 0)
                                        @foreach($donations as $donation)
                                            <tr>
                                                <td>{{$donation->viewer->stream->user->pseudo}}</td>
                                                <td>{{$donation->amount}} €</td>
                                                <td>{{$donation->message}}</td>
                                                <td>{{ Carbon\Carbon::parse($donation->created_at)->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <i>Aucun don reçu pour l'instant.</i>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            @else
                                <p>Vous n'avez pas accés à cette information.</p>
                            @endif
                        </div>


                    </div>
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
        .cardInfo {
            background-color: #fff;
            border: 1px solid #dedede;
            -webkit-box-shadow: 0 1px 2px 0 rgba(0,0,0,0.07);
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.07);
            margin-bottom: 30px;
            border-radius: 6px;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $(".anciennete").each(function(){
                var date = $(this).data("date");
                var anciennete = dateDiff(new Date(date), new Date());

                var text = "( ";
                if(anciennete.month!=0) text+=anciennete.month+"m ";
                if(anciennete.day!=0)   text+=anciennete.day+"j ";
                if(anciennete.hour!=0)  text+=anciennete.hour+"h ";
                text += " )";
                $(this).html(text);
            });
        });

        function dateDiff(date1, date2){
            var diff = {}                           // Initialisation du retour
            var tmp = date2 - date1;

            tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
            diff.sec = tmp % 60;                    // Extraction du nombre de secondes

            tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
            diff.min = tmp % 60;                    // Extraction du nombre de minutes

            tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
            diff.hour = tmp % 24;                   // Extraction du nombre d'heures

            tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
            diff.day = tmp%24;

            tmp = Math.floor((tmp-diff.day)/30);    // Nombre de mois restants
            diff.month = tmp%30;

            return diff;
        }
    </script>
@endsection