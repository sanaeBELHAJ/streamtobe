<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" 
        aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route' => 'report', 'method' => 'post', 'class' => '']) !!}
            <div class="modal-content">
                <div class="form-group">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Signaler l'utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ Form::hidden('streamer', $streamer->pseudo, []) }}
                        <div class="form-row">
                            {!! Form::label('categoryReport',"Type d'infraction :") !!}
                        </div>
                        <div class="form-row">
                            <select name="category" id="categoryReport">
                                @foreach($reportCat as $category)
                                    <option value="{{$category->name}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row mt-2">
                            {!! Form::label('descriptionReport','Description :') !!}
                            {!! Form::textarea('description',
                                                null, 
                                                ['id' => 'descriptionReport',
                                                'class' => 'form-control form-control-sm', 
                                                'size' => '30x5',
                                                'required' => 'required',
                                                'placeholder' => 'Informations complémentaires obligatoires.']) !!}
                        </div>
                        <div class="form-row">
                            {!! $errors->first('category', 
                                '<small class="form-text col-12 alert alert-danger">:message
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}

                            {!! $errors->first('streamer', 
                                    '<small class="form-text col-12 alert alert-danger">:message
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                    </button></small>') !!}
                            
                            {!! $errors->first('description', 
                                    '<small class="form-text col-12 alert alert-danger">:message
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></small>') !!}
                        </div>
                        <div class="form-row mt-2">
                            <small>Assurez-vous que l'utilisateur ne respecte pas les <a type="link" target="_blank" href="{{ route('cgu') }}">Conditions Générales d'Utilisation</a> avant de déposer une plainte.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>