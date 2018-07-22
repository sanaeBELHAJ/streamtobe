{!! Form::model($user, ['route' => ['home.updateInfos'], 'method' => 'patch', 'class' => '', 'files' => true]) !!}
<div class="card card-lg">

<div class="card-body">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="pictureAccountInput">
                <img class="pictureAccount" id="pictureAccount" style="background-image:url(<?php echo asset('storage/'.$user->avatar); ?>)" alt="" title="Image de profil">
                <small class="text-muted">(Max: 2 Mo, Types : PNG, JPG, GIF)</small>
            </label>
            {!! Form::file('pictureAccount', ['id' => 'pictureAccountInput', 
                                                'class' => 'd-none',
                                                'onchange' => "readURL(this);",
                                                'accept' => '.jpg, .jpeg, .png, .gif'
                                            ]) !!}
            {!! $errors->first('pictureAccount', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('pseudoAccount','Pseudo :') !!}
            {!! Form::text('pseudo',null, ['id' => 'pseudoAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => 'required',
                                            'placeholder' => 'Pseudo']) !!}
            {!! $errors->first('pseudo', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('emailAccount','Adresse email :') !!}
            {!! Form::email('email', $user->email, ['id' => 'emailAccount',
                                        'class' => 'form-control form-control-sm', 
                                        'placeholder' => 'Email']) !!}
            {!! $errors->first('email', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
        </div>
    </div>

<div class="form-row">
    <div class="form-group col-lg-3 col-sm-12 col-md-6 col-mb-6">
    <label>Pays : &nbsp;
        <select id="countryAccount" class="update_stream form-control w-50 d-inline" data-config="type" name="country">
            @if($countries)
                @foreach($countries as $country)
                    <option value="{{$country->id}}"
                            @if($user->id_countries == $country->id)
                            selected
                            @endif>{{$country->name}}</option>
                @endforeach
            @endif
        </select>
    </label>
    {!! $errors->first('country',
                        '<small class="form-text alert alert-danger">:message
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></small>') !!}
</div>
</div>
    <div class="form-row">
        <div class="form-group col-12">
            {!! Form::label('descriptionAccount','Description :') !!}
            {!! Form::textarea('description',null, ['id' => 'descriptionAccount',
                                                    'class' => 'form-control form-control-sm', 
                                                    'size' => '30x5',
                                                    'placeholder' => 'Descrivez-vous en quelques lignes. Ce paragraphe apparaitra en dessous de votre page de streaming.']) !!}
            {!! $errors->first('description', 
                                '<small class="form-text alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('pwdAccount','Modifier votre mot de passe :') !!}
            {!! Form::password('password', ['id' => 'pwdAccount',
                                            'class' => 'form-control form-control-sm', 
                                            'required' => false]) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('pwdConfirmAccount','Confirmation du nouveau mot de passe :') !!}
            {!! Form::password('password_confirmation', ['id' => 'pwdConfirmAccount',
                                                    'class' => 'form-control form-control-sm', 
                                                    'required' => false]) !!}
        </div>
        {!! $errors->first('password', 
                            '<small class="form-text alert alert-danger">:message
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></small>') !!}
    </div>
    <div class="form-row">
        <div class="form-group form-group col-lg-6 col-sm-12 col-md-12 col-mb-12 ">
            <button type="button" class="btn btn-secondary" style="background-color:darkred; color:white;" data-toggle="modal" data-target="#removeAccount">
                Verrouiller mon compte
            </button>
        </div>
        <div class="form-group col-lg-6 col-sm-12 col-md-12 col-mb-12 ">
            {!! Form::submit("Enregistrer les modifications", ['class' => 'btn btn-success pull-right']) !!}
        </div>
    </div>
</div>
</div>
{!! Form::close() !!}


<!-- Modal de suppression de compte-->
<div class="modal fade" id="removeAccount" tabindex="-1" role="dialog" aria-labelledby="removeAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'DELETE', 'route' => ['home.destroy', $user->pseudo]]) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="removeAccountLabel">Désactivation de mon compte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Attention, vous ne pourrez plus réactiver votre compte par la suite !</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>