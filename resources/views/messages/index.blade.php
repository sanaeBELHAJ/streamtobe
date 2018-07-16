@extends('layouts.template')

@section('content')
	<div class="container-fluid top-2 bottom h-75" style="height:100%;">
		<div class="row h-100">
			<p class="text-center mx-auto">
					<small>Les utilisateurs à qui vous pouvez envoyer un message apparaissent dans la liste à gauche.</small>
					<br>
					<small><b>Vous devez vous abonner mutuellement à vos chaines respectives.</b></small>
			</p>
			@if(env('APP_ENV') != "production")
				<iframe src="http://localhost:3001/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@else
				<iframe src="https://mp.streamtobe.com/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@endif
		</div>
	</div>
@endsection
