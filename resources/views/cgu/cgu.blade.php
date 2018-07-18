@extends('layouts.template')

@section('content')
    <div class="container top-2 bottom">
		<div class="col-sm-offset-12 col-sm-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Conditions générale d'utilisation</h3>
				</div>
				<div class="panel-body"> 
					<p>{!! setting('site.cgu') !!}</p>
				</div>
			</div>
		</div>
    </div>
@endsection

