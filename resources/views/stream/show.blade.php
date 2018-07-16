@extends('layouts.template')

@section('content')

<div class ="container-fluid">
    <div class="row">
        <div class="col-sm-12 pull-right top-2 bottom">
            <div class="container-fluid row" >
                <div id="player" class="col-12 col-md-8 mt-8">
                        <div class="bodyDiv">
                            <div id="stream-info" @if($streamer->stream->status == 1) hidden="true" @endif>
                                <img class="w-100" src="http://anthillonline.com/wp-content/uploads/2013/07/videoPlaceholder.jpg"/>
                            </div>
                            {{-- Vidéo --}}
                            <div style="height: 529px;" id="videos-container" hidden="true"></div>
                                {{-- Nombre de viewers --}}
                            <i class="fa fa-eye"></i><span id="visitorStream"></span>
                            @auth
                                @if($streamer->stream->status == 1 && $streamer->id != Auth::user()->id)
                                    <!-- list of all available broadcasting rooms -->
                                    <table style="width: 100%;" id="rooms-list"></table>
                                @endif
                            @endauth
                            @guest
                                <table style="width: 100%;" id="rooms-list"></table>
                            @endguest
                        </div>
                </div>

                {{-- Chatbox --}}
                <div id="messages" class="col-12 d-sm-block col-md-4">
                    @guest
                        <p class="border-top d-flex flex-column justify-content-center text-center h-100">
                            Connectez-vous pour rédiger un message.
                        </p>
                    @else
                        @if(env('APP_ENV') != "production")
                            <iframe src="http://localhost:3000/?stream={{$streamer->pseudo}}&token={{$user->token}}" class="h-100 w-100"></iframe>
                        @else
                        <iframe src="https://io.streamtobe.com/?stream={{$streamer->pseudo}}&token={{$user->token}}" class="h-100 w-100"></iframe>
                        @endif
                    @endguest
                </div>
            </div>

            <div id="infos" class="d-none d-sm-block mt-4">
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
                    @if(Auth::check() && $streamer->id == Auth::user()->id)

                        <div class="mt-4" id="config_stream">
                            <h3 class="h3 mb-5">Configurer mon stream</h3>
                            <div class="form-row">
                                <div class="experiment form-group col-lg-6 col-sm-12 col-md-12 col-mb-12 ">
                                        Type de diffusion : &nbsp;
                                        <select id="broadcasting-option" class="form-control d-inline w-50">
                                            <option>Stream classique</option>
                                            <option>Stream audio</option>
                                        </select>
                                </div>
                                <div class="form-group col-lg-6 col-sm-12 col-md-12 col-mb-12">
                                    Catégorie :
                                    <select id="stream_type" class="update_stream form-control d-inline w-50" data-config="type">
                                        @foreach($themes as $theme)
                                        <optgroup label="{{$theme->name}}">
                                            @foreach($theme->types as $type)
                                            <option value="{{$type->name}}">{{$type->name}}</option>
                                            @endforeach
                                        </optgroup>descriptionAccount
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-sm-12 col-md-12 col-mb-12">
                                    Nom de la chaine : &nbsp;
                                    <input id="stream_title" class="form-control d-inline w-50 update_stream"
                                            data-config="title" type="text" placeholder="Titre du stream"
                                            value="{{$streamer->stream->title}}">
                                </div>
                                <div class="form-group col-lg-6 col-sm-12 col-md-12 col-mb-12">
                                    <label class="switch align-middle m-0">
                                        <input id="setup-new-broadcast" class="update_stream" name="stream_submit" data-config="status" type="checkbox"
                                                @if($streamer->stream->status == 0)
                                                    value="On"
                                                @else
                                                    value="Off"
                                                    checked
                                                @endif >
                                        <span class="slider round"></span>
                                    </label>
                                    Activer / Interrompre la diffusion
                                </div>
                            </div>
                        </div>
                    @else {{-- Panel d'action du viewer --}}
                        <div class="col-12 col-md-8 d-flex justify-content-between">

                            {{-- Report --}}
                            <p class="col text-center">
                                @if($report)
                                    <button class="btn btn-danger btn-lg btn-rounded m-l-10" disabled>Vous avez déjà signalé <br>cet utilisateur.</button>
                                @else
                                    <button class="btn btn-danger btn-lg btn-rounded m-l-10"
                                            data-toggle="modal" data-target="#reportModal">Signaler cet utilisateur <i class="fa fa-warning"></i></button>
                                    @include('stream.modal.report')
                                @endif
                            </p>

                            {{-- Giveaway --}}
                            <p class="col text-center">
                                <button class="btn btn-primary btn-lg btn-rounded m-l-10" data-toggle="modal"
                                    data-target="#paymentModal">Faire un don <i class="fa fa-dollar"></i></button>
                            </p>
                            @include('stream.modal.payment')

                            {{-- Following --}}
                            <p class="col text-center">
                                @php ($IsCurrentViewer = 0)
                                @foreach($user->viewers as $viewer)
                                    @if($streamer->stream->id == $viewer->stream_id)
                                        <button class="btn btn-facebook btn-lg btn-rounded m-l-10 w-100 float-none @if($viewer->is_follower == 1) @else d-none @endif"
                                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                                title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner <i class="fas fa-unlink"></i></button>
                                        <button class="btn btn-facebook btn-lg btn-rounded m-l-10 w-100 float-none @if($viewer->is_follower == 0) @else d-none @endif"
                                                data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                                title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner <i class="fa fa-heart-o"></i></button>
                                        @php ($IsCurrentViewer = 1)
                                    @endif
                                @endforeach
                                @if($IsCurrentViewer == 0)
                                    <button class="btn-facebook btn-rounded w-100 float-none btn  d-none"
                                            data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                            title="Retirer cette chaine de vos favoris" data-value="0" >Se désabonner <i class="fas fa-unlink"></i></button>
                                    <button class="btn-facebook btn-rounded w-100 float-none btn"
                                            data-toggle="tooltip" data-placement="top" data-streamer="{{$streamer->pseudo}}"
                                            title="Mettre cette chaine dans vos favoris" data-value="1" >S'abonner  <i class="fa fa-heart-o"></i></button>
                                @endif
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
                <p class="sliderText col-3 text-center m-0" data-value="2">Configuration</p>
            </div>
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
            background-color: #1BBC9B;
        }
        #config_stream input:focus + .slider {
            box-shadow: 0 0 1px #1BBC9B;
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

    <script src="/js/broadcast.js"></script>
    <script src="/js/rtc-connection.js"></script>
    <script src="https://cdn.webrtc-experiment.com/DetectRTC.js"></script>
    <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <script src="https://cdn.webrtc-experiment.com/IceServersHandler.js"></script>
    <script src="https://cdn.webrtc-experiment.com/CodecsHandler.js"></script>
    @auth
        @if($streamer->id != Auth::user()->id)
            <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        @endif
    @endauth

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
            /* Config stream (owner) */
            function updateStream(){
                var key = $(this).data('config');
                var value = "";
                switch(key){
                    case "title":
                        value = $("#stream_title").val();break;
                    case "status":
                        value = $("#setup-new-broadcast").is(":checked");break;
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
                        console.log(data + "YES");
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
            //Edit modération/bannissement
            function statusViewer(pseudo, rank, set){
                $.ajax({
                    url: "/updateViewer",
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        pseudo: pseudo,
                        rank: rank,
                        set: set
                    }
                })
                    .done(function(data){
                        updateList();
                        $(".searchUser").val("");
                    })
                    .fail(function(data){
                        console.log(data);
                    });
            }
            //Detection du click() sur les boutons générés par les appels Ajax
            if($("#config_stream").length > 0){
                $("#config_stream").on("click", ".rmvRankUser", function(){
                    var action = $(this).data('action');
                    var pseudo = $(this).data('pseudo');
                    statusViewer(pseudo, action, 0);
                });
            }
            //Liste modérateurs / bannis
@auth
            updateList();
            function updateList(){
                $.ajax({
                    url: "/getStreamViewer",
                    type: 'GET'
                })
                    .done(function(data){
                        $("#listMods").html('');
                        $("#listBans").html('');
                        $.each(data, function(index, element){
                            var text = "";
                            text +='<tr class="d-flex justify-content-between">';
                            text += '<td>'+element.pseudo+'</td>';
                            if(element.rank == 1)
                                text += "<td><button data-action='mod' data-pseudo='"+element.pseudo+"' ";
                            else if(element.rank == -1)
                                text += "<td><button data-action='ban' data-pseudo='"+element.pseudo+"' ";
                            text += "class='rmvRankUser btn btn-primary'>Retirer</button></td>";
                            text += "</tr>";
                            if(element.rank == 1)
                                $("#listMods").append(text);
                            else if(element.rank == -1)
                                $("#listBans").append(text);
                        });
                    })
                    .fail(function(data){
                        console.log(data);
                    });
            }
            @endauth
            /* Stream WEBRTC */
            var config = {
                openSocket: function(config) {
                    var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
                    config.channel = config.channel || "{{$streamer->pseudo}}-{{$streamer->id}}";
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
                    document.title = "{{ $streamer->stream->title }}";
                },
                onRoomFound: function(room) {
                    $.ajax({
                        url: "/getStreamStatusInfo",
                        type: 'GET',
                        dataType: "JSON",
                        data: {
                            streamerId: '<?php echo $streamer->id;?>'
                        }
                    }).done(function (data) {
                        if (data[0].status === 1) {
                            var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
                            if (alreadyExist) return;
                            if (typeof roomsList === 'undefined') roomsList = document.body;
                            broadcastUI.joinRoom({
                                roomToken: room.roomToken,
                                joinUser: room.broadcaster
                            });
                            document.getElementById('stream-info').hidden = true;
                            document.getElementById('videos-container').hidden = false
                        }
                    });
                },
                onNewParticipant: function(numberOfViewers) {
                    document.getElementById('visitorStream').innerHTML = "";
                    document.getElementById('visitorStream').innerHTML = ' ' + numberOfViewers + '';
                }
            };
            function setupNewBroadcastButtonClickHandler(onload) {
                if (onload == 1) return 0;
                if (document.getElementById('setup-new-broadcast').value === "Off") {
                    <?php $streamer->stream->status = 0;?>
                            if(config) {
                                if (config.attachStream) {
                                    config.attachStream.getTracks().forEach(function (track) {
                                        if (track)
                                            track.stop();
                                    });
                                }
                    }
                    document.getElementById('videos-container').innerHTML = "";
                    document.getElementById("setup-new-broadcast").value = "On";
                    document.getElementById('stream_title').disabled = false;
                    document.getElementById('videos-container').hidden = true;
                    document.getElementById('stream-info').hidden = false;
                }else {
                    <?php $streamer->stream->status = 1;?>
                    document.getElementById("setup-new-broadcast").value = "Off";
                    document.getElementById('stream_title').disabled = true;
                    @auth
                    @if($streamer->id == Auth::user()->id)
                    DetectRTC.load(function () {
                        captureUserMedia(function () {
                            var shared = 'video';
                            if (window.option == 'Stream audio') {
                                shared = 'audio';
                            }
                            broadcastUI.createRoom({
                                roomName: (document.getElementById('stream_title') || {}).value || 'Anonymous',
                                isAudio: shared === 'audio'
                            });
                        });
                        document.getElementById('videos-container').hidden = false;
                        document.getElementById('stream-info').hidden = true;
                    });
                    @endif
                    @endauth
                }
            }
            var broadcastUI = broadcast(config);
            var videosContainer = document.getElementById('videos-container') || document.body;
            var setupNewBroadcast = document.getElementById('setup-new-broadcast');
            var broadcastingOption = document.getElementById('broadcasting-option');
            var roomsList = document.getElementById('rooms-list');
            if (setupNewBroadcast) setupNewBroadcast.onclick = setupNewBroadcastButtonClickHandler;
            function captureUserMedia(callback) {
                var constraints = null;
                window.option = broadcastingOption ? broadcastingOption.value : '';
                if (option === 'Stream audio') {
                    constraints = {
                        audio: true,
                        video: false
                    };
                    if(DetectRTC.hasMicrophone !== true) {
                        alert('DetectRTC library is unable to find microphone; maybe you denied microphone access once and it is still denied or maybe microphone device is not attached to your system or another app is using same microphone.');
                    }
                }
                if (option === 'Stream caméra') {
                    var video_constraints = {
                        mandatory: {
                            chromeMediaSource: 'Stream caméra'
                        },
                        optional: []
                    };
                    constraints = {
                        audio: false,
                        video: video_constraints
                    };
                    if(DetectRTC.isScreenCapturingSupported !== true) {
                        alert('DetectRTC library is unable to find Stream caméra capturing support. You MUST run chrome with command line flag "chrome --enable-usermedia-Stream caméra-capturing"');
                    }
                }
                if (option != 'Stream audio' && option != 'Stream caméra' && DetectRTC.hasWebcam !== true) {
                    alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
                }
                var htmlElement = document.createElement(option === 'Stream audio' ? 'audio' : 'video');
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
                        addStreamStopListener(stream,  function() {
                        });
                        videosContainer.appendChild(htmlElement);
                        callback && callback();
                    },
                    onerror: function() {
                        if (option === 'Stream audio') alert('Impossible d\'avoir accès à votre microphone');
                        else if (option === 'Stream caméra') {
                            if (location.protocol === 'http:') alert('Activez HTTPS.');
                            else alert('Capture vidéo est desactivé ou non authorisé. L\'avez-vous autorisé dans votre navigateur "?');
                        } else alert('Impossible d\'accéder à votre webcam');
                    },
                };
                if (constraints) mediaConfig.constraints = constraints;
                getUserMedia(mediaConfig);
            }
            function addStreamStopListener(stream, callback) {
                var streamEndedEvent = 'ended';
                if ('oninactive' in stream) {
                    streamEndedEvent = 'inactive';
                }
                stream.addEventListener(streamEndedEvent, function() {
                    callback();
                    callback = function() {};
                }, false);
                stream.getVideoTracks().forEach(function(track) {
                    track.addEventListener(streamEndedEvent, function() {
                        callback();
                        callback = function() {};
                    }, false);
                });
            }
            function start() {
                @auth
                        @if($streamer->id != Auth::user()->id)
                    videosContainer.innerHTML = "";
                document.getElementById('stream-info').hidden = false;
                @elseif($streamer->id == Auth::user()->id)
                if (setupNewBroadcast.value === "Off") {
                    setupNewBroadcast.click();
                    videosContainer.innerHTML = "";
                    document.getElementById("setup-new-broadcast").value = "On";
                    document.getElementById('stream_title').disabled = false;
                    document.getElementById('stream-info').hidden = false;
                    document.getElementById('videos-container').hidden = true;
                }
                @endauth
                        @endif
                        @guest
                    videosContainer.innerHTML = "";
                document.getElementById('stream-info').hidden = false;
                document.getElementById('videos-container').hidden = true;
                @endguest
            };
            start();
        });
    </script>
@endsection