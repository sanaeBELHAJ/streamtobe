Modification de mon compte
{!! Form::model($user, ['route' => ['home.updateInfos'], 'method' => 'patch', 'class' => '']) !!}
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('pseudoAccount','Pseudo :') !!}
            {!! Form::text('pseudo',null, ['id' => 'pseudoAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Pseudo']) !!}
            {!! $errors->first('pseudo', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('emailAccount','Adresse email :') !!}
            {!! Form::email(null, $user->email, ['id' => 'emailAccount',
                                        'class' => 'form-control form-control-sm', 
                                        'readonly' => 'readonly',
                                        'disabled' => 'disabled',
                                        'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('nameAccount','Nom :') !!}
            {!! Form::text('name',null, ['id' => 'nameAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Nom']) !!}
            {!! $errors->first('name', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('firstNameAccount','Prénom :') !!}
            {!! Form::text('firstname',null, ['id' => 'firstNameAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Prénom']) !!}
            {!! $errors->first('firstname', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('pwdAccount','Enregistrez un mot de passe :') !!}
            {!! Form::password('password', ['id' => 'pwdAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => false]) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('pwdConfirmAccount','Confirmation du mot de passe :') !!}
            {!! Form::password('password_confirmation', ['id' => 'pwdConfirmAccount',
                                                    'class' => 'form-control form-control-sm', 
                                                    'required' => false]) !!}
        </div>
        {!! $errors->first('password', "<p class='col-12'><small class='form-text alert-danger'>:message</small></p>") !!}
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeAccount">
                Verrouiller mon compte
            </button>
        </div>
        <div class="form-group col-md-6 text-right">
            {!! Form::submit("Enregistrer les modifications", ['class' => 'btn btn-success pull-right']) !!}
        </div>
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


<!-- Modal -->
<div class="modal fade" id="removeAccount" tabindex="-1" role="dialog" aria-labelledby="removeAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'DELETE', 'route' => ['home.destroy', $user->pseudo]]) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="removeAccountLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Attention, vous ne pourrez plus réactiver votre compte par la suite !</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Attention : cette décision est définitive !\')']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>