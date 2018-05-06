@extends('layouts.template')

@section('content')
	<div class="container-fluid">
		<div class="row">

			{{-- Lecteur vidéo --}}
			<div id="player" class="col-12 col-md-8 mt-4">
				<video id="videoPlayer" controls>
					<source/>
				</video>
			</div>

			{{-- Chatbox --}}
			<div id="messages" class="col-12 d-sm-block col-md-4 mt-4">
				@guest
                    <p class="border-top d-flex flex-column justify-content-center text-center h-100">
						Connectez-vous pour rédiger un message.
					</p>
				@else
					<iframe src="http://localhost:8080/?stream={{$streamer->pseudo}}&token={{$user->token}}" class="h-100 w-100"></iframe>
				@endguest
			</div>


			<div id="infos" class="col-12 d-none d-sm-block mt-4">
				@auth
					{{-- Configuration du stream par le propriétaire --}}
					@if($streamer->id == Auth::user()->id)
						<div class="col-12 mt-4" id="config_stream">
							<h3>Configurer mon stream</h3>
							<p>
								Titre : 
								<input id="stream_title" class="update_stream" data-config="title" type="text" value="{{$streamer->stream->title}}">
								Catégorie : 
								<select id="stream_type" class="update_stream" data-config="type">
									@foreach($themes as $theme)
										<optgroup label="{{$theme->name}}">
											@foreach($theme->types as $type)
												<option value="{{$type->name}}">{{$type->name}}</option>
											@endforeach
										</optgroup>
									@endforeach
								</select>
							</p>

							<label>
								<label class="switch align-middle m-0">
									<input id="stream_status" class="update_stream" data-config="status" type="checkbox" 
											@if($streamer->stream->status == 1) checked @endif >
									<span class="slider round"></span>
								</label> 
								Activer / Interrompre la diffusion
							</label>
						</div>

						{{-- <div class="col-12 mt-4">
							<h3>Gestion des spectateurs</h3>
							
						</div> --}}
					@else {{-- Panel d'action du viewer --}}
						<div class="col-12 col-md-8 d-flex justify-content-between">
							<p class="col text-center">
								@if(isset($report))
									<i class="fas fa-2x fa-exclamation" data-toggle="tooltip" 
										data-placement="top" title="Vous avez déjà signalé cette chaine"></i>
								@else
									<i class="btn fas fa-2x fa-exclamation-triangle" data-toggle="tooltip" 
										data-placement="top" title="Signaler cette chaine"></i>
								@endif
							</p>
							<p class="col text-center">
								@if(isset($sub))
									<i class="btn fas fa-2x fa-comment" data-toggle="tooltip" 
										data-placement="top" title="Envoyer un message au streamer"></i>	
								@else
									<i class="far fa-2x fa-comment" data-toggle="tooltip" 
										data-placement="top" title="Communication privée reservée aux abonnés"></i>
								@endif
							</p>
							<p class="col text-center">
								<i class="btn fas fa-2x fa-gift" data-toggle="tooltip" 
									data-placement="top" title="Faire un don / S'abonner"></i>
							</p>
							<p class="col text-center">
								@if(isset($follower))
									<i class="btn fas fa-2x fa-star" data-toggle="tooltip" 
										data-placement="top" title="Ne plus suivre cette chaine"></i>
								@else
									<i class="btn far fa-2x fa-star" data-toggle="tooltip" 
										data-placement="top" title="Suivre cette chaine"></i>
								@endif
							</p>
						</div>
					@endif
				@endauth
				
				{{-- Description du streamer --}}
				<div class="col-12 mt-4">
					<div id="streamer">
						<h3>Description du streamer</h3>
						<p></p>
					</div>
				</div>
			</div>
			
			{{-- Boutons d'affichage mobile --}}
			<div id="responsive_slider" class="col-12 d-flex justify-content-around d-sm-none mt-4 mb-5 row">
				<p class="sliderText col-3 text-center font-weight-bold m-0" data-value="1">Chat</p>
				<input type="range" min="1" max="2" value="1" class="btn slider col-6" id="myRange"> 
				<p class="sliderText col-3 text-center m-0" data-value="2">Description</p>
			</div>		
		</div>
	</div>
@endsection

@section('css')
	<style>
		video{
			background-color:black;
			width:100%;
			height:100%;
		}

		@media(max-width: 768px){
			#messages, #infos{
				height: 400px;
			}
		}

		/* The slider itself */
		#responsive_slider .slider {
			-webkit-appearance: none;  /* Override default CSS styles */
			appearance: none;
			padding: 0;
			width: 100%; /* Full-width */
			height: 25px; /* Specified height */
			background: #d3d3d3; /* Grey background */
			outline: none; /* Remove outline */
			opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
			-webkit-transition: .2s; /* 0.2 seconds transition on hover */
			transition: opacity .2s;
		}

		/* Mouse-over effects */
		#responsive_slider .slider:hover {
			opacity: 1; /* Fully shown on mouse-over */
		}

		/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */ 
		#responsive_slider .slider::-webkit-slider-thumb {
			-webkit-appearance: none; /* Override default look */
			appearance: none;
			width: 50%; /* Set a specific slider handle width */
			height: 25px; /* Slider handle height */
			background: #4CAF50; /* Green background */
			cursor: pointer; /* Cursor on hover */
		}

		#responsive_slider .slider::-moz-range-thumb {
			width: 50%; /* Set a specific slider handle width */
			height: 25px; /* Slider handle height */
			background: #4CAF50; /* Green background */
			cursor: pointer; /* Cursor on hover */
		}

		/*******/


		/* The switch - the box around the slider */
		#config_stream .switch {
			position: relative;
			display: inline-block;
			width: 60px;
			height: 34px;
		}

		/* Hide default HTML checkbox */
		#config_stream .switch input {display:none;}

		/* The slider */
		#config_stream .slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		#config_stream .slider:before {
			position: absolute;
			content: "";
			height: 90%;
			width: 26px;
			left: 4px;
			bottom: 5%;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		#config_stream input:checked + .slider {
			background-color: #2196F3;
		}

		#config_stream input:focus + .slider {
			box-shadow: 0 0 1px #2196F3;
		}

		#config_stream input:checked + .slider:before {
			-webkit-transform: translateX(26px);
			-ms-transform: translateX(26px);
			transform: translateX(26px);
		}

		/* Rounded sliders */
		#config_stream .slider.round {
			border-radius: 34px;
		}

		#config_stream .slider.round:before {
			border-radius: 50%;
		}
	</style>
@endsection

@section('js')
	<script>	
		$(function(){
			//Texte du slider
			$('.sliderText').click(function(){
				$('#myRange').val($(this).data('value')).change();
			});

			//Slider en vue responsive
			$('#myRange').change(function(){
				//Chat
				if($(this).val()==1){
					$('.sliderText[data-value="1"]').addClass('font-weight-bold');
					$('.sliderText[data-value="2"]').removeClass('font-weight-bold');
					
					$('#messages').addClass('d-12').removeClass('d-none');
					$('#infos').addClass('d-none').removeClass('d-12');
				}//Description
				else{
					$('.sliderText[data-value="1"]').removeClass('font-weight-bold');
					$('.sliderText[data-value="2"]').addClass('font-weight-bold');
					
					$('#messages').addClass('d-none').removeClass('d-12');
					$('#infos').addClass('d-12').removeClass('d-none');
				}
			});
			
			/* Config stream */
			function updateStream(){
				var key = $(this).data('config');
				var value = "";

				switch(key){
					case "title":
						value = $("#stream_title").val();break;
					case "status":
						value = $("#stream_status").is(":checked");break;
					case "type":
						value = $("#stream_type").val();break;
				}
				
				$.ajax({
					url: "/updateStream",
					type: 'POST',
					data: {
						config: key,
						value: value
					}
				})
				.done(function(data){
					console.log(data);
				})
				.fail(function(data){
					console.log(data);
				});
			}
			$(".update_stream").change(updateStream);
			
		});
	</script>
@endsection