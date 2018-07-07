@extends('layouts.template')

@section('content')

<div class ="container-fluid">
    <div class="row">
        <div class="col-sm-2 profil-panel">
            <div class="top bottom"></div>
        </div>
        <div class="col-sm-10 pull-right top bottom">
            <div class="row">
                <div id="player" class="col-12 col-md-8 mt-8">
                    @auth
                        <div class="bodyDiv">
                            {{-- Vidéo --}}
                            <div id="videos-container"></div>
                            @if($streamer->id == Auth::user()->id)
                                <section class="experiment">
                                    <section>
                                        <select id="broadcasting-option">
                                            <option>Audio + Video</option>
                                            <option>Only Audio</option>
                                            <option>Screen</option>
                                        </select>
                                        <input type="text" id="broadcast-name">
                                        <button id="setup-new-broadcast" class="setup">Setup New Broadcast</button>
                                    </section>
                                </section>
                            @else
                            <!-- list of all available broadcasting rooms -->
                                <table style="width: 100%;" id="rooms-list"></table>

                            @endif



                            {{-- Nombre de viewers --}}
                            @if($streamer->stream->status == 1)

                            @endif
                        </div>
                    @endauth
                </div>

                {{-- Chatbox --}}
                <div id="messages" class="col-12 d-sm-block col-md-4">
                    @guest
                        <p class="border-top d-flex flex-column justify-content-center text-center h-100">
                            Connectez-vous pour rédiger un message.
                        </p>
                    @else
                        <iframe src="<?php echo str_replace(":8000", "", Request::root()); ?>:3000/?stream={{$streamer->pseudo}}&token={{$user->token}}" class="h-100 w-100"></iframe>
                    @endguest
                </div>
            </div>

            <div id="infos" class="col-12 d-none d-sm-block mt-4">
                @if(Session::has('message'))
                    <p class="mt-2 alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('message') }}
                    </p>
                @endif

                @auth
                    {{-- Configuration du stream par le propriétaire --}}
                    @if($streamer->id == Auth::user()->id)
                        <div class="col-12 mt-4" id="config_stream">
                            <h3 class="mb-5">Configurer mon stream</h3>
                            <div class="row">
                                <p class="col-12 col-md-6">
                                    Titre : 
                                    <input id="stream_title" class="update_stream" data-config="title" type="text" value="{{$streamer->stream->title}}">
                                </p>
                                <p class="col-12 col-md-6">
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
                            </div>

                            <label>
                                <label class="switch align-middle m-0">
                                    <input id="stream_status" class="update_stream" name="stream_submit" data-config="status" type="checkbox" 
                                            onclick="stream( '{{$streamer->name}}');"
                                            @if($streamer->stream->status == 0) 
                                                value="On"
                                            @else
                                                value="Off"
                                                checked 
                                            @endif >
                                    <span class="slider round"></span>
                                </label>
                                Activer / Interrompre la diffusion
                            </label>
                                    
                        </div>
                    @else {{-- Panel d'action du viewer --}}
                        <div class="col-12 col-md-8 d-flex justify-content-between">

                            {{-- Report --}}
                            <p class="col text-center">
                                @if($report)
                                <i class="fas fa-2x fa-exclamation" data-toggle="tooltip" 
                                data-placement="top" title="Vous avez déjà signalé cette chaine"></i>
                                @else
                                <a class="btn" data-toggle="modal" data-target="#reportModal">
                                    <i class="fas fa-2x fa-exclamation-triangle" data-toggle="tooltip" 
                                    data-placement="top" title="Signaler cette chaine"></i>
                                </a>
                                @include('stream.modal.report')
                                @endif
                            </p>

                            {{-- Private Message --}}
                            <p class="col text-center">
                                @foreach($user->viewers as $viewer)
                                @if($streamer->stream->id == $viewer->stream_id)
                                @foreach($viewer->subscribes as $subscription)
                                @if($subscription->status == 1)
                                <i class="btn fas fa-2x fa-comment" data-toggle="tooltip" 
                                data-placement="top" title="Envoyer un message au streamer"></i>	
                                @break
                                @else
                                <i class="far fa-2x fa-comment" data-toggle="tooltip" 
                                data-placement="top" title="Communication privée reservée aux abonnés"></i>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                            </p>

                            {{-- Giveaway --}}
                            <p class="col text-center">
                                <a class="btn" data-toggle="modal" data-target="#paymentModal">
                                    <i class="btn fas fa-2x fa-gift" data-toggle="tooltip" 
                                    data-placement="top" title="Faire un don / S'abonner"></i>
                                </a>								
                            </p>
                            @include('stream.modal.payment')

                            {{-- Following --}}
                            <p class="col text-center">
                                @foreach($user->viewers as $viewer)
                                @if($streamer->stream->id == $viewer->stream_id)
                                @if($viewer->is_follower == 1)
                                <i class="btn fas fa-2x fa-star" id="follow_stream" data-toggle="tooltip" 
                                data-placement="top" title="Ne plus suivre cette chaine"></i>
                                @else
                                <i class="btn far fa-2x fa-star" id="follow_stream" data-toggle="tooltip" 
                                data-placement="top" title="Suivre cette chaine"></i>
                                @endif
                                @endif
                                @endforeach
                            </p>
                        </div>

                        {{-- Description du streamer --}}
                        <div class="col-12 mt-4">
                            <div id="streamer">
                                <h3>Description du streamer</h3>
                                <p>{{$streamer->description}}</p>
                            </div>
                        </div>
                    @endif
                @endauth				
            </div>

            {{-- Boutons d'affichage mobile --}}
            <div id="responsive_slider" class="col-12 d-flex justify-content-around d-sm-none mt-4 mb-5 row">
                <p class="sliderText col-3 text-center font-weight-bold m-0" data-value="1">Chat</p>
                <input type="range" min="1" max="2" value="1" class="btn slider col-6" id="myRange"> 
                <p class="sliderText col-3 text-center m-0" data-value="2">Description</p>
            </div>		
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        table.listUsers{
            min-height: 200px;
            margin-bottom: 100px;
            border: 1px solid;
        }

        table.listUsers tbody tr{
            padding: 0 20px;
        }

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

        /* Bouton d'activation du stream */
        
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
    @auth
    <script src="/js/broadcast.js"></script>
	<script src="/js/rtc-connection.js"></script>
    <script src="https://cdn.webrtc-experiment.com/DetectRTC.js"></script>
    <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.webrtc-experiment.com/IceServersHandler.js"></script>
    <script src="https://cdn.webrtc-experiment.com/CodecsHandler.js"></script>
		@if($streamer->id != Auth::user()->id)
			<script src="https://www.paypalobjects.com/api/checkout.js"></script>
		@endif
	@endauth
    <script>
        if(!location.hash.replace('#', '').length) {
            location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
            location.reload();
        }
    </script>
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
			
			/* Buttons stream (viewer) */
			function followingStream(){
				var following = ($("#follow_stream").hasClass("fas")) ? 0 : 1;
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
					if(data == 0){
						$("#follow_stream").removeClass("fas")
											.addClass("far")
											.attr('data-original-title', 'Suivre cette chaine')
											.tooltip("show");
					}
					else{
						$("#follow_stream").removeClass("far")
											.addClass("fas")
											.attr('data-original-title', 'Ne plus suivre cette chaine')
											.tooltip("show");
					}
				})
				.fail(function(data){
					console.log(data);
				});
			}
			$("#follow_stream").click(followingStream);

			/* Config stream (owner) */
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
			
			/* Paypal Button */
			if($("#paymentModal").length > 0){
				paypal.Button.render({
					env: 'sandbox', // Or 'production',
					
					client: {
						sandbox:    'AXHXCd6YkvkTlnMfRhC0I9jCwej0WmraIWjsDnzraah26zhzv805-1zPqv-JehHe01-T8aACfmv69ESo',
						//production: 'xxxxxxxxx'
					},
					
					commit: true, // Show a 'Pay Now' button

					style: {
						color: 'gold',
						size: 'small'
					},

					payment: function(data, actions) {
						//Set up the payment here
						return actions.payment.create({
							payment: {
								transactions: [
									{
										amount: { 
											total: $('#giveaway_change').val(), 
											currency: 'EUR'
										}
									}
								]
							}
						});
					},

					onAuthorize: function(data, actions) {
						//Execute the payment here
						return actions.payment.execute().then(function(payment) {
							// The payment is complete!
							// You can now show a confirmation message to the customer
							payment.streamer = $('#pseudo').val();
							payment.message = $('#giveaway_message').val();
							$.ajax({
								url: "/validGiveaway",
								type: 'POST',
								dataType: "JSON",
								data: {
									payment: payment
								}
							})
							.done(function(data){
								console.log(data);
							})
							.fail(function(data){
								console.log(data);
							});
						});
					},

					onCancel: function(data, actions) {
						//Buyer cancelled the payment
					},

					onError: function(err) {
						//An error occurred during the transaction
					}
				}, '#paypal-button');
			}
		});

        var config = {
            openSocket: function(config) {
                var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';

                config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                var sender = Math.round(Math.random() * 999999999) + 999999999;

                io.connect(SIGNALING_SERVER).emit('new-channel', {
                    channel: config.channel,
                    sender: sender
                });

                var socket = io.connect(SIGNALING_SERVER + config.channel);
                socket.channel = config.channel;
                socket.on('connect', function () {
                    if (config.callback) config.callback(socket);
                });

                socket.send = function (message) {
                    socket.emit('message', {
                        sender: sender,
                        data: message
                    });
                };

                socket.on('message', config.onmessage);
            },
            onRemoteStream: function(htmlElement) {
                videosContainer.appendChild(htmlElement);
                rotateInCircle(htmlElement);
            },
            onRoomFound: function(room) {
                var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
                if (alreadyExist) return;

                if (typeof roomsList === 'undefined') roomsList = document.body;

                var tr = document.createElement('tr');
                tr.innerHTML = '<td><strong>' + room.roomName + '</strong> is broadcasting his media!</td>' +
                    '<td><button class="join">Join</button></td>';
                roomsList.appendChild(tr);

                var joinRoomButton = tr.querySelector('.join');
                joinRoomButton.setAttribute('data-broadcaster', room.broadcaster);
                joinRoomButton.setAttribute('data-roomToken', room.broadcaster);
                joinRoomButton.onclick = function() {
                    this.disabled = true;

                    var broadcaster = this.getAttribute('data-broadcaster');
                    var roomToken = this.getAttribute('data-roomToken');
                    broadcastUI.joinRoom({
                        roomToken: roomToken,
                        joinUser: broadcaster
                    });
                    hideUnnecessaryStuff();
                };
            },
            onNewParticipant: function(numberOfViewers) {
                document.title = 'Viewers: ' + numberOfViewers;
            },
            onReady: function() {
                console.log('now you can open or join rooms');
            }
        };

        function setupNewBroadcastButtonClickHandler() {
            document.getElementById('broadcast-name').disabled = true;
            document.getElementById('setup-new-broadcast').disabled = true;

            DetectRTC.load(function() {
                captureUserMedia(function() {
                    var shared = 'video';
                    if (window.option == 'Only Audio') {
                        shared = 'audio';
                    }
                    if (window.option == 'Screen') {
                        shared = 'screen';
                    }

                    broadcastUI.createRoom({
                        roomName: (document.getElementById('broadcast-name') || { }).value || 'Anonymous',
                        isAudio: shared === 'audio'
                    });
                });
                hideUnnecessaryStuff();
            });
        }

        function captureUserMedia(callback) {
            var constraints = null;
            window.option = broadcastingOption ? broadcastingOption.value : '';
            if (option === 'Only Audio') {
                constraints = {
                    audio: true,
                    video: false
                };

                if(DetectRTC.hasMicrophone !== true) {
                    alert('DetectRTC library is unable to find microphone; maybe you denied microphone access once and it is still denied or maybe microphone device is not attached to your system or another app is using same microphone.');
                }
            }
            if (option === 'Screen') {
                var video_constraints = {
                    mandatory: {
                        chromeMediaSource: 'screen'
                    },
                    optional: []
                };
                constraints = {
                    audio: false,
                    video: video_constraints
                };

                if(DetectRTC.isScreenCapturingSupported !== true) {
                    alert('DetectRTC library is unable to find screen capturing support. You MUST run chrome with command line flag "chrome --enable-usermedia-screen-capturing"');
                }
            }

            if (option != 'Only Audio' && option != 'Screen' && DetectRTC.hasWebcam !== true) {
                alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
            }

            var htmlElement = document.createElement(option === 'Only Audio' ? 'audio' : 'video');

            htmlElement.muted = true;
            htmlElement.volume = 0;

            try {
                htmlElement.setAttributeNode(document.createAttribute('autoplay'));
                htmlElement.setAttributeNode(document.createAttribute('playsinline'));
                htmlElement.setAttributeNode(document.createAttribute('controls'));
            } catch (e) {
                htmlElement.setAttribute('autoplay', true);
                htmlElement.setAttribute('playsinline', true);
                htmlElement.setAttribute('controls', true);
            }

            var mediaConfig = {
                video: htmlElement,
                onsuccess: function(stream) {
                    config.attachStream = stream;

                    videosContainer.appendChild(htmlElement);
                    rotateInCircle(htmlElement);

                    callback && callback();
                },
                onerror: function() {
                    if (option === 'Only Audio') alert('unable to get access to your microphone');
                    else if (option === 'Screen') {
                        if (location.protocol === 'http:') alert('Please test this WebRTC experiment on HTTPS.');
                        else alert('Screen capturing is either denied or not supported. Are you enabled flag: "Enable screen capture support in getUserMedia"?');
                    } else alert('unable to get access to your webcam');
                }
            };
            if (constraints) mediaConfig.constraints = constraints;
            getUserMedia(mediaConfig);
        }

        var broadcastUI = broadcast(config);

        /* UI specific */
        var videosContainer = document.getElementById('videos-container') || document.body;
        var setupNewBroadcast = document.getElementById('setup-new-broadcast');
        var roomsList = document.getElementById('rooms-list');

        var broadcastingOption = document.getElementById('broadcasting-option');

        if (setupNewBroadcast) setupNewBroadcast.onclick = setupNewBroadcastButtonClickHandler;

        function hideUnnecessaryStuff() {
            var visibleElements = document.getElementsByClassName('visible'),
                length = visibleElements.length;
            for (var i = 0; i < length; i++) {
                visibleElements[i].style.display = 'none';
            }
        }

        function rotateInCircle(video) {
            video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
            setTimeout(function() {
                video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
            }, 1000);
        }

	</script>

@endsection