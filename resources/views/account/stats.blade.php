@extends('layouts.template')

@section('content')
<div class="container-fluid" >
<div class="row">
    <div class="col-sm-12 pull-right top-2 bottom">
        <p>Dons reçus par {{$streamer->pseudo}}</p>
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
    </div>
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