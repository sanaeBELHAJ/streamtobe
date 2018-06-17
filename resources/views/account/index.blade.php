@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-12 col-md-3">
            <nav class="nav nav-tabs" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-item active col-4 col-md-12"  data-toggle="pill" 
                    href="#v-pills-account" role="tab" aria-controls="v-pills-account" 
                    aria-selected="true" title="Modifier mon compte">
                    <span class="d-block d-md-none text-center"><i class="fas fa-user-circle"></i></span>
                    <span class="d-none d-md-block">MON COMPTE</span>
                </a>
                <a class="nav-link nav-item col-4 col-md-12"  data-toggle="pill" 
                    href="#v-pills-stats" role="tab" aria-controls="v-pills-stats" 
                    aria-selected="false" title="Consulter les statistiques de mon stream">
                    <span class="d-block d-md-none text-center"><i class="fas fa-signal"></i></span>
                    <span class="d-none d-md-block">MON STREAM</span>
                </a>
                <a class="nav-link nav-item col-4 col-md-12"  data-toggle="pill" 
                    href="#v-pills-subscription" role="tab" aria-controls="v-pills-subscription" 
                    aria-selected="false" title="Obtenir un récapitulatif de mes activités">
                    <span class="d-block d-md-none text-center"><i class="far fa-credit-card"></i></span>
                    <span class="d-none d-md-block">HISTORIQUE</span>
                </a>
            </nav>
        </div>
        <div class="col-12 col-md-9">
            @if(Session::has('message'))
                <p class="mt-2 alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ Session::get('message') }}
                </p>
            @endif
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" 
                aria-labelledby="v-pills-account-tab">
                    {{--  COMPTE  --}}
                    @include('account.infos')
                </div>
                <div class="tab-pane fade" id="v-pills-stats" role="tabpanel" 
                aria-labelledby="v-pills-stats-tab">
                    {{--  STREAM  --}}
                    @include('account.stats')
                </div>
                <div class="tab-pane fade" id="v-pills-subscription" role="tabpanel" 
                aria-labelledby="v-pills-subscription-tab">
                    {{--  HISTORIQUE  --}}
                    @include('account.subscription')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .pictureAccount{
        width: 100px;
        display: inline-block;
        height: 100px;
        border: 1px solid;
        border-radius: 50%;
        vertical-align: bottom;
        cursor: pointer;
    }
</style>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $( window ).resize(function() {
                if($(this).width() <= 768)
                    $('nav').removeClass('flex-column');
                else
                    $('nav').addClass('flex-column');
            });

            $(".anciennete").each(function(){
                var date = $(this).data("date");
                var anciennete = dateDiff(new Date(date), new Date());
                console.log(anciennete);
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