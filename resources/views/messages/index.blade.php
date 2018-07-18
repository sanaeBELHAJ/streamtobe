@extends('layouts.template')

@section('content')
	<div class="container-fluid h-100" style="min-height:80vh;">
		<div class="row h-100">

			@if(env('APP_ENV') != "production")
				<iframe src="http://localhost:3001/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@else
				<iframe src="https://mp.streamtobe.com/?token={{$user->token}}" class="w-100 h-100 border-0"></iframe>
			@endif
		</div>
	</div>
@endsection
