@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            <nav class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-item active" id="v-pills-account-tab" data-toggle="pill" 
                    href="#v-pills-account" role="tab" aria-controls="v-pills-account" 
                    aria-selected="true">Mon compte</a>
                <a class="nav-link nav-item" id="v-pills-stream-tab" data-toggle="pill" 
                    href="#v-pills-stream" role="tab" aria-controls="v-pills-stream" 
                    aria-selected="false">Mon prochain stream</a>
                <a class="nav-link nav-item" id="v-pills-stats-tab" data-toggle="pill" 
                    href="#v-pills-stats" role="tab" aria-controls="v-pills-stats" 
                    aria-selected="false">Statistiques</a>
                <a class="nav-link nav-item" id="v-pills-subscription-tab" data-toggle="pill" 
                    href="#v-pills-subscription" role="tab" aria-controls="v-pills-subscription" 
                    aria-selected="false">Mes abonnements</a>
            </nav>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" 
                aria-labelledby="v-pills-account-tab">
                    {{--  Mes informations personnelles  --}}
                    @include('account.infos')
                </div>
                <div class="tab-pane fade" id="v-pills-stream" role="tabpanel" 
                aria-labelledby="v-pills-stream-tab">
                    {{--  Mon stream  --}}
                    @include('account.stream')
                </div>
                <div class="tab-pane fade" id="v-pills-stats" role="tabpanel" 
                aria-labelledby="v-pills-stats-tab">
                    {{--  Mes statistiques  --}}
                    @include('account.stats')
                </div>
                <div class="tab-pane fade" id="v-pills-subscription" role="tabpanel" 
                aria-labelledby="v-pills-subscription-tab">
                    {{--  Mes abonnements  --}}
                    @include('account.subscription')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection