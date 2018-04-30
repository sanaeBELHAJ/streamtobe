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
			<div id="messages" class="col-12 col-md-4 mt-4">
				@guest
                    <p class="border-top d-flex flex-column justify-content-center text-center h-100">Connectez-vous pour rédiger un message.</p>
				@else
					<iframe src="http://localhost:8080/" class="h-100 w-100"></iframe>
				@endguest
			</div>

			{{-- Description du streamer --}}
			<div id="infos" class="col-12 mt-4 d-none d-sm-block">
				<div class="col-12 col-md-8 d-flex justify-content-between">
					<p class="col text-center">
						<i class="fas fa-2x fa-exclamation-triangle"></i>
					</p>
					<p class="col text-center">
						<i class="far fa-2x fa-comment"></i>
					</p>
					<p class="col text-center">
						<button>S'abonner</button>
					</p>
					<p class="col text-center">
						<button>Suivre cette chaine</button>
					</p>
				</div>

				<div class="col-12 mt-4">
					<div id="streamer">
						<h3>Description du streamer</h3>
						<p></p>
					</div>
				</div>
			</div>

			{{-- Boutons d'affichage mobile --}}
			<div id="" class="col-12 d-flex justify-content-around d-sm-none">
				<button class="btn btn-primary btn-lg active">CHAT</button>
				<button class="btn btn-primary btn-lg">DESCRIPTION</button>
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
			#messages{
				height: 400px;
			}
		}
	</style>
@endsection

@section('js')
	<script>
		$(function(){

			/*$(document).on('submit', '#messageForm', function(e) {  
				e.preventDefault();
				$('textarea[name="messageContent"]').text('');
				
				$.ajax({
					method: $(this).attr('method'),
					url: $(this).attr('action'),
					data: $(this).serialize(),
					dataType: "json"
				})
				.done(function(data) {
					$('.alert-success').removeClass('hidden');
					$('#myModal').modal('hide');
				})
				.fail(function(data) {
					$.each(data.responseJSON, function (key, value) {
						var input = '#formRegister input[name=' + key + ']';
						$(input + '+small').text(value);
						$(input).parent().addClass('has-error');
					});
				});
			});*/

		})
	</script>
@endsection