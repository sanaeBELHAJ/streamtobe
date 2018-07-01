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
    <thead>
        <tr>
            <th class="text-center" colspan="4">Dons reçus</th>
        </tr>
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
                    <i>Vous n'avez reçu aucun don pour l'instant.</i>
                </td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>
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