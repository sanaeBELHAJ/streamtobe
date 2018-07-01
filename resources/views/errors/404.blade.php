@extends('layouts.template')

@section('content')
    <div class="container top bottom">
		<div class="col-sm-offset-4 col-sm-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">{{ __('Huh...we got a problem') }}</h3>
				</div>
				<div class="panel-body"> 
					<p>{{ __("The page you were looking for doesn't exist...") }}</p>
				</div>
			</div>
		</div>
    </div>
@endsection