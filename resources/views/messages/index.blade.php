@extends('layouts.template')

@section('content')
    <div class="container-fluid top bottom">
			<div class="row">
				<iframe src="<?php echo str_replace(":8000","",Request::root()); ?>:3001/?token={{$user->token}}" 
								class="w-100 border-0"></iframe>
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