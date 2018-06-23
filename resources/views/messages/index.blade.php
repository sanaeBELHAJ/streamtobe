@extends('layouts.template')

@section('content')
    <div class="container-fluid top bottom">
		<div class="row">
			<iframe src="http://localhost:3000/?token={{$user->token}}" class="w-100 border-0"></iframe>
		</div>
    </div>
@endsection

@section('css')
<style>
	iframe{
		height: 59vh;
	}
</style>
@endsection