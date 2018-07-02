@extends('layouts.template')

@section('content')
    <style>
   .card {
     box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
     max-width: 300px;
     margin: auto;
     text-align: center;
     font-family: arial;
   }

   .title {
     color: grey;
     font-size: 18px;
   }

   button {
     border: none;
     outline: 0;
     display: inline-block;
     padding: 8px;
     color: white;
     background-color: #4b367c;
     text-align: center;
     cursor: pointer;
     width: 100%;
     font-size: 18px;
   }

  .machaine:hover{
        background-color:#b82e8a;
        opacity: 0.7;
   }
   button:hover{
     opacity: 0.7;
   }
   </style>

<div class="row  top bottom ">
    <div class="col-sm-4">
        <div>
            @foreach($user->viewers as $viewer)
                @if($streamer->stream->id == $viewer->stream_id)
                    @if($viewer->is_follower == 1)
                        <center>
                            <button class="btn btn-follow" id="abo" href="#">S'abonner</button>
                        </center>
                        <center>
                            <button class="btn btn-follow" id="desabo" href="#" disabled>Désabonner</button>
                        </center>
                        @break
                    @endif

                    @if($loop->last)
                        <center>
                            <button class="btn btn-follow" id="abo" href="#" disabled>S'abonner</button>
                        </center>
                        <center>
                            <button class="btn btn-follow" id="desabo" href="#">Désabonner</button>
                        </center>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    <div class="col-sm-4">
        <h2 style="text-align:center"></h2>
        <div class="card">
            <div class="cadre-style">
                <center>
                    <img src="<?php echo asset('storage/'.$streamer->avatar); ?>" alt="Image de profil" title="Image de profil" style="width:50%; height: 10%">
                </center> 
            </div>
            <h1>{{ $streamer->pseudo }}</h1>
          <p class="title">{{ $streamer->description }}</p>

          <span>
            @if($streamer->country != null)
                <i class="material-icons" style="font-size: 16px;">location_on</i>{{ $streamer->country->name }}
                <img style="width:10%" src="{{ $streamer->country->svg }}">
            @else
                <i class="material-icons" style="font-size: 16px;">location_on</i>
                Inconnu
            @endif
          </span>
          <div style="margin: 24px 0;">
         </div>
         <p><button>Contacter</button></p>
        </div>
    </div>
    <div class="col-sm-4">
        
        <p>{{ $streamer->pseudo }} est actuellement en direct, vous pouvez rejoindre sa chaine.</p>
        <div>
            <center>
                <a class="machaine active" href="{{ route('stream.show', ['user' => $streamer->pseudo]) }}">                  
                    <i style="font-size: 50px;margin-top: 10px" class="material-icons">
                       play_circle_filled
                    </i>
                </a>
            </center>
        </div>
    </div>
</div>
@endsection

@section('js')	
	<script>
		$(function(){		
            /* Buttons stream (viewer) */
			function followingStream(){
                var following = ($(this).is("#abo")) ? 1 : 0;
                var stream = "{{$streamer->pseudo}}";

				$.ajax({
					url: "/followStream",
					type: 'POST',
					data: {
						stream: stream,
						is_following: following
					}
				})
				.done(function(data){
                    $(".btn-follow").prop('disabled', function(i, v) { return !v; });
				})
				.fail(function(data){
					console.log(data);
				});
            }
			$(".btn-follow").click(followingStream);
		});
	</script>
@endsection