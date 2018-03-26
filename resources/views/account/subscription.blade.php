Liste de tous mes abonnements
{!! Form::open(['url' => 'user', 'id' => 'formRegister']) !!}
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('emailRegister','Adresse email :') !!}
            {!! Form::email('email',null, ['id' => 'emailRegister',
                                        'class' => 'form-control form-control-sm', 
                                        'required' => 'required',
                                        'placeholder' => 'Email']) !!}
            {!! $errors->first('email', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('pseudoRegister','Pseudo :') !!}
            {!! Form::text('pseudo',null, ['id' => 'pseudoRegister',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Pseudo']) !!}
            {!! $errors->first('pseudo', '<small class="form-text alert-danger">:message</small>') !!}
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('pwdRegister','Enregistrez un mot de passe :') !!}
            {!! Form::password('password', ['id' => 'pwdRegister',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('pwdConfirmRegister','Confirmation du mot de passe :') !!}
            {!! Form::password('password_confirmation', ['id' => 'pwdConfirmRegister',
                                                    'class' => 'form-control form-control-sm', 
                                                    'required' => 'required']) !!}
        </div>
        {!! $errors->first('password', "<p class='col-12'><small class='form-text alert-danger'>:message</small></p>") !!}
    </div>
    <div class="row">
        <span class="col-sm-12 text-right">
        {!! Form::submit("S'inscrire", ['class' => 'btn btn-success pull-right']) !!}
        </span>
    </div>
    @if(Session::has('messageRegister'))
        <p class="mt-2 alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session::get('message') }}
        </p>
    @endif
{!! Form::close() !!}