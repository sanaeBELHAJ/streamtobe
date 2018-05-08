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
        });
    </script>
@endsection