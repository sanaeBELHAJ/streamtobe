@extends('template')

@section('title')
    Authentification
@endsection

@section('content')
    <div>
        <h1>Nouveau ? Rejoignez-nous dès maintenant !</h1>
        <div>
            <h3>INSCRIPTION</h3>
            <div>
                {!! Form::open(['url' => 'register', 'class' => 'notRedirect', 'id' => 'formRegister']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('emailRegister','Saisissez votre adresse e-mail') !!}
                        {!! Form::email('email','', ['id' => 'emailRegister','class' => 'form-control', 'required' => 'required']) !!}
                        {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                        
                        <div class="alert alert-dismissible alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Un email de confirmation vous a été adressé.
                        </div>
                        <div class="alert alert-dismissible alert-warning" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Un compte existe déjà à cette adresse.
                        </div>
                        <div class="alert alert-dismissible alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            Impossible d'envoyer l'email de confirmation.
                        </div>
                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    {!! Form::submit("S'inscrire", ['class' => 'btn btn-success pull-right']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
        <hr>
        <div>
            <h3>CONNEXION</h3>
            <div>
                <!-- Authentification -->
                {!! Form::open(['url' => 'login', 'class' => 'notRedirect', 'id' => 'formLogin']) !!}
                <div class="form-group">
                    {!! Form::label('emailLogin','Saisissez votre adresse e-mail') !!}
                    {!! Form::email('email','',['id'=>'emailLogin',
                                                'class' => 'form-control',
                                                'required' => 'required']) !!}
                    {!! $errors->first('emailLogin', '<small class="help-block">:message</small>') !!}

                    {!! Form::label('passwordLogin','Saisissez votre mot de passe') !!}
                    {!! Form::password('password',[ 'id' => 'passwordLogin',
                                                    'class' => 'form-control',
                                                    'required' => 'required']) !!}
                    {!! $errors->first('passwordLogin', '<small class="help-block">:message</small>') !!}
                    <div class="alert alert-dismissible alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Vous êtes déjà connectés, merci de rafraichir la page.
                    </div>
                    <div class="alert alert-dismissible alert-warning" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Les identifiants sont incorrects.
                    </div>
                    <div class="alert alert-dismissible alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Authentification impossible.
                    </div>
                    <div class="alert alert-dismissible alert-danger-login alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Votre compte n'est pas accessible : vous devez avoir reçu un lien de confirmation par mail, ou vous avez été banni.
                    </div>
                </div>
                <div class="row">
                    <span class="col-xs-6 col-sm-6 col-md-6 text-left">
                        <a  class="btn btn-warning" role="button" data-toggle="collapse" 
                        href="#forgetPwd" aria-expanded="false" aria-controls="forgetPwd">
                        Mot de passe oublié ?</a>
                    </span>
                    <span class="col-xs-6 col-sm-6 col-md-6 text-right">
                        {!! Form::submit("Se connecter", ['class' => 'btn btn-success']) !!}
                    </span>
                </div>
                {!! Form::close() !!}
            </div>
            <p>
                <a href="#">Récupération du compte</a>
                {!! Form::open(['url' => 'forgot', 'class' => 'notRedirect', 'id' => 'formBackUp']) !!}
                <div class="form-group">
                    {!! Form::label('emailBackUp','Un email vous sera envoyé.') !!}
                    {!! Form::email('email','',['id' => 'emailBackUp',
                                                'class' => 'form-control',
                                                'required' => 'required']) !!}
                    {!! $errors->first('emailBackUp', '<small class="help-block">:message</small>') !!}
                    <div class="alert alert-dismissible alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        L'email de récupération vient de vous être adressé.
                    </div>
                    <div class="alert alert-dismissible alert-warning" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Aucun compte n'est associé à cette adresse email.
                    </div>
                    <div class="alert alert-dismissible alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Impossible d'envoyer l'email de récupération de compte.
                    </div>
                </div>
                <div class="text-right">
                    {!! Form::submit("Récupérer mon compte", ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </p>
        </div>
        <hr>
        <div>
            <img src="#">
            <img src="#">
            <img src="#">
            <img src="#">
        </div>
    </div>
@endsection