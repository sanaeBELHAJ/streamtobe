@extends('layouts.template')

@section('content')
    <div class="container-fluid top bottom">
		<div class="row">
			@if(env('APP_ENV') != "production")
				<iframe src="http://localhost:3001/?token={{$user->token}}" class="w-100 border-0"></iframe>
			@else
				<iframe src="https://io.streamtobe.com/?token={{$user->token}}" class="w-100 border-0"></iframe>
			@endif
		</div>
    </div>
@endsection

@section('css')
<style>
	iframe{
		height: 65vh;
	}
</style>
@endsection