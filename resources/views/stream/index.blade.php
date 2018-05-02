@extends('layouts.template')

@section('content')
    <div class="container">
		<div class="col-sm-offset-4 col-sm-4">
			@if(session()->has('ok'))
				<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
			@endif
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Liste des streams</h3>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>Pseudo</th>
							<th>Image</th>
							<th>Statut</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($streams as $stream)
							<tr>
								<td class="text-primary">
									<strong>{!! $stream->user->pseudo !!}</strong>
								</td>
								<td>
									<img class="pictureAccount" src="<?php echo asset('storage/'.$stream->user->avatar); ?>" 
										alt="" title="Image de profil">
								</td>
								<td>
									@if($stream->status==1)
										{!! link_to_route('stream.show', 'En ligne', [$stream->user->pseudo], ['class' => 'btn btn-success btn-block']) !!}
									@else
										{!! link_to_route('stream.show', 'Hors ligne', [$stream->user->pseudo], ['class' => 'btn btn-secondary btn-block']) !!}
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
    </div>
@endsection

@section('css')
<style>
	.pictureAccount{
		width: 30%;
	}
</style>
@endsection