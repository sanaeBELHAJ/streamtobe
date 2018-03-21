@extends('template')

@section('title')
    Authentification
@endsection

@section('content')
    <h1 class="text-center">Nouveau ? Rejoignez-nous dès maintenant !</h1>
    <div class="d-flex justify-content-center row">
        <div class="col-sm-12 col-md-6">
            <!-- Inscription -->
            <div class="card bg-light">
                <div class="card-header">INSCRIPTION</div>
                <div class="card-body">
                    {!! Form::open(['url' => 'register', 'id' => 'formRegister']) !!}
                        <div class="form-group">
                            {!! Form::label('emailRegister','Saisissez votre adresse e-mail') !!}
                            {!! Form::email('email',null, ['id' => 'emailRegister',
                                                        'class' => 'form-control form-control-sm', 
                                                        'required' => 'required',
                                                        'placeholder' => 'Email']) !!}
                            {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                {!! Form::label('pwdRegister','Saisissez un mot de passe') !!}
                                {!! Form::password('password', ['id' => 'pwdRegister',
                                                                'class' => 'form-control form-control-sm', 
                                                                'required' => 'required']) !!}
                                {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('pwdConfirmRegister','Confirmez le mot de passe') !!}
                                {!! Form::password('pwdConfirm', ['id' => 'pwdConfirmRegister',
                                                                    'class' => 'form-control form-control-sm', 
                                                                    'required' => 'required']) !!}
                                {!! $errors->first('pwdConfirm', '<small class="help-block">:message</small>') !!}
                            </div>
                        </div>
                        <div class="row">
                            <span class="col-sm-12 text-right">
                            {!! Form::submit("S'inscrire", ['class' => 'btn btn-success pull-right']) !!}
                            </span>
                        </div>
                        @if(Session::has('message'))
                            <p class="mt-2 alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ Session::get('message') }}
                            </p>
                        @endif
                    {!! Form::close() !!}
                </div>
            </div>
            <hr>
            <!-- Authentification -->
            <div class="card bg-light">
                <div class="card-header">CONNEXION</div>
                <div class="card-body">
                    {!! Form::open(['url' => 'login', 'class' => 'notRedirect', 'id' => 'formLogin']) !!}
                        <div class="form-group">
                            {!! Form::label('emailLogin','Saisissez votre adresse e-mail') !!}
                            {!! Form::email('email','',['id'=>'emailLogin',
                                                        'class' => 'form-control form-control-sm',
                                                        'required' => 'required',
                                                        'placeholder' => 'Email']) !!}
                            {!! $errors->first('emailLogin', '<small class="help-block">:message</small>') !!}

                            {!! Form::label('passwordLogin','Saisissez votre mot de passe') !!}
                            {!! Form::password('password',[ 'id' => 'passwordLogin',
                                                            'class' => 'form-control form-control-sm',
                                                            'required' => 'required']) !!}
                            {!! $errors->first('passwordLogin', '<small class="help-block">:message</small>') !!}
                            {{--  <div class="alert alert-dismissible alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Vous êtes déjà connectés, merci de rafraichir la page.
                                Les identifiants sont incorrects.
                                Authentification impossible.
                                Votre compte n'est pas accessible : vous devez avoir reçu un lien de confirmation par mail, ou vous avez été banni.
                            </div>  --}}
                        </div>
                        <div class="row">
                            <span class="col-sm-12 text-right">
                                {!! Form::submit("Se connecter", ['class' => 'btn btn-success']) !!}
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <hr>
            <!-- Récupération -->
            <div class="card bg-light">
                <div class="card-header">Mot de passe oublié ?</div>
                <div class="card-body">
                    {!! Form::open(['url' => 'forgot', 'class' => 'notRedirect', 'id' => 'formBackUp']) !!}
                        <div class="form-group">
                            {!! Form::label('emailBackUp','Un email vous sera envoyé.') !!}
                            {!! Form::email('email','',['id' => 'emailBackUp',
                                                        'class' => 'form-control form-control-sm',
                                                        'required' => 'required',
                                                        'placeholder' => 'Email']) !!}
                            {!! $errors->first('emailBackUp', '<small class="help-block">:message</small>') !!}
                            {{--  <div class="alert alert-dismissible alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                L'email de récupération vient de vous être adressé.
                                Aucun compte n'est associé à cette adresse email.
                                Impossible d'envoyer l'email de récupération de compte.
                            </div>  --}}
                        </div>
                        <div class="text-right">
                            {!! Form::submit("Récupérer mon compte", ['class' => 'btn btn-success']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-around">
                <i class="fab fa-github fa-3x "></i>
                <i class="fab fa-facebook fa-3x "></i>
                <i class="fab fa-twitter fa-3x "></i>
                <i class="fab fa-twitch fa-3x "></i>
            </div>
        </div>
    </div>
@endsection