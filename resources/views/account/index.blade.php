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
<div class="col-sm-offset-4 col-sm-4">
    <div class="panel panel-primary">	
        <div class="panel-body"> 
            <div class="col-sm-12">
                {{--  {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
                <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                      {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                </div>
                <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                      {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                      {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('admin', 1, null) !!}Administrateur
                        </label>
                    </div>
                </div>
                    {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}  --}}
            </div>
        </div>
    </div>
</div>
@endsection
