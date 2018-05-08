@extends('layouts.template')

@section('content')
    <div class="container">
		<div class="row mt-5">
			<div class="col-12">
				@if(session()->has('ok'))
					<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
				@endif
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Liste des streams</h3>
					</div>
					
					<table class="table col-12">
						<thead>
							<tr>
								<th>Image</th>
								<th>Pseudo</th>						
								<th>Statut</th>
							</tr>
						</thead>
						<tbody>
							@if(count($streams) > 0)
								@foreach ($streams as $stream)
									<tr>
										<td>
											<img class="col-7 col-sm-5 col-md-2" src="<?php echo asset('storage/'.$stream->user->avatar); ?>" 
												alt="" title="Image de profil">
										</td>
										<td class="text-primary">
											<strong>{!! $stream->user->pseudo !!}</strong>
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
							@else
								<tr>
									<td colspan="3" class="text-center">
										<i>Vous ne suivez actuellement aucun stream.</i>
									</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
@endsection

@section('css')
<style>
	.table td{
		vertical-align: middle;
	}

	.pictureAccount{
		width: 10%;
	}
</style>
@endsection