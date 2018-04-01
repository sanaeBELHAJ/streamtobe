@extends('layouts.template')

@section('content')
    <br>
    <div class="col-sm-offset-4 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Liste des utilisateurs</h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Pseudo</th>
						<th>Image</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
						<tr>
							<td>{!! $user->id !!}</td>
							<td class="text-primary"><strong>{!! $user->pseudo !!}</strong></td>
							<td><img class="pictureAccount" src="<?php echo asset('storage/'.$user->picture); ?>" alt="" title="Image de profil"></td>
							<td>{!! link_to_route('user.show', 'Voir', [$user->pseudo], ['class' => 'btn btn-success btn-block']) !!}</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
	</div>
@endsection