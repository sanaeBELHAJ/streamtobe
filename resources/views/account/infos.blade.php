Modification de mon compte
{!! Form::model($user, ['route' => ['home.updateInfos'], 'method' => 'patch', 'class' => '']) !!}
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('emailAccount','Adresse email :') !!}
            {!! Form::email('email',null, ['id' => 'emailAccount',
                                        'class' => 'form-control form-control-sm', 
                                        'required' => 'required',
                                        'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('pseudoAccount','Pseudo :') !!}
            {!! Form::text('pseudo',null, ['id' => 'pseudoAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Pseudo']) !!}
            {!! $errors->first('pseudo', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
    </div>
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
    <div class="row">
        <span class="col-sm-12 text-right">
        {!! Form::submit("Enregistrer les modifications", ['class' => 'btn btn-success pull-right']) !!}
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