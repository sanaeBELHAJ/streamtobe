@extends('layouts.template')

@section('content')
    <div class="col-sm-offset-4 col-sm-4">
    	<br>
		<div class="panel panel-primary">	
			<div class="panel-heading">Fiche d'utilisateur</div>
			<div class="panel-body"> 
				<img class="pictureAccount" src="<?php echo asset('storage/'.$user->picture); ?>" alt="" title="Image de profil">
				<p>Pseudo : {{ $user->pseudo }}</p>
				<p>Email : {{ $user->email }}</p>
			</div>
		</div>				
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection