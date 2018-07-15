@extends('layouts.template')

@section('content')
	<div class="container-fluid top-1 bottom h-75">
		<div class="row h-100">

			@if(env('APP_ENV') != "production")
				<iframe src="http://localhost:3001/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@else
				<iframe src="https://mp.streamtobe.com/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@endif
		</div>
	</div>
@endsection
