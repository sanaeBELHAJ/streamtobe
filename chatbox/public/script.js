/* Connexion à socket.io */
var environment = (window.location.hostname == "localhost") ? "http://localhost:8000" : "https://streamtobe.com";
var environmentSocket = (window.location.hostname == "localhost") ? "http://localhost:3000" : "https://io.streamtobe.com";

var socket = io.connect(environmentSocket);
var token = getUrlParameter('token');
var stream = getUrlParameter('stream');
socket.emit('join', token, stream);

function sendMessage(){
    event.preventDefault();
    var message = $('#message').val();

    if(message != "")
        socket.emit('message', message); // Publie le message

    $('#message').val('').focus(); // Vide la zone de Chat et remet le focus dessus
    $("#zone_chat").animate({ scrollTop: $("#zone_chat")[0].scrollHeight }, 100);
}

// Lorsqu'on envoie le formulaire, on transmet le message et on l'affiche sur la page
$('#formulaire_chat').submit(function (event) {
    sendMessage();
    return false; // Permet de bloquer l'envoi "classique" du formulaire
});

$(window).on('keydown', function(e) {
    if (e.which == 13) { 
        sendMessage();
        return false;
    }
});

//Lorsqu'on souhaite modérer un message, on envoie son ID
$('#zone_chat').on('click',".delete", function(){
    console.log($(this).html());
    var message_id = $(this).parent().data('message');
    socket.emit('delete', message_id);
});

//Arrivée d'un nouvel utilisateur sur le chat
socket.on('welcome', function() {
    $('#zone_chat').append(`<p><em>
        Important : Tout message ou contenu enfreignant les règles d'utilisations du site
        entrainera des sanctions immédiates pouvant aller au bannissement.</em></p>`);
});

// Quand on reçoit un message, on l'insère dans la page
socket.on('message', function(data) {
    var text = "<p data-message='"+data.message_id+"'>";
        text += (data.admin && data.viewer_rank==0) ? "<i class='fas fa-ban delete'></i>" : "";
        text += "<img class='chat_avatar' src='"+environment+"/storage/"+data.avatar+"'>";
        switch(data.viewer_rank){
            case 1: //modérateur
                text += "<span class='chat_user mod'>";
                break;
            case 2: //streamer
                text += "<span class='chat_user streamer'>";
                break;
            default: //viewer
                text += "<span class='chat_user'>";
                break;
        }
        text += data.pseudo+":</span>";
        text += "<span class='chat_message'> "+data.message+"</span>";
    text += "</p>";
    $('#zone_chat').append(text);
    $("#zone_chat").animate({ scrollTop: $("#zone_chat")[0].scrollHeight }, 100);
});

//Modération d'un message
socket.on('delete', function(message_id) {
    $('p[data-message="'+message_id+'"] .chat_message').html('<em>Ce message a été supprimé.</em>');
    $('p[data-message="'+message_id+'"] .fa-ban.delete').hide();
});

//Bannissement de l'utilisateur
socket.on('ban', function() {
    $('#zone_chat').append("<p>Envoi impossible : Vous avez été banni du chat.</p>");
});

//Retrait du statut de modérateur
socket.on('demod', function() {
    $('#zone_chat').append("<p>Erreur : Vous n'êtes pas modérateur de ce chat.</p>");
});

//Réception de dons
socket.on('dons', function(data) {
    $('#zone_chat').append('<p><em>Don de '+data.amount+data.currency+' a été réalisé par '+data.pseudo+' !</em></p>');
    if(data.message)
        $('#zone_chat').append('<p>'+data.message+'</p>');
});

//Arrivée d'un nouvel utilisateur sur le chat
socket.on('error', function(error) {
    
    switch(error.type){
        case 'user_missing':
            alert("Identifiant utilisateur incorrect");
    }

    $("#formulaire_chat textarea").prop("disabled", true);
    $("#formulaire_chat input").prop("disabled", true);
});

// Affichage de la liste des viewers
socket.on('updateList', function(data) {
    var text = "";
    
    $.each(data, function(index, user){
        var color = "user_viewer";
        text += "<p class='nav-link text-center' data-pseudo='"+user.pseudo+"'>";
            //Si le viewer est un modo / streamer
            if(user.is_staff){
                var ban = "<i class='btn fas fa-user-times ban' title='Bannir cet utilisateur du chat'></i>";
                var mod = "<i class='btn fas fa-cog modo' title='Promouvoir cet utilisateur comme modérateur'></i>";
                
                if(user.rank<0){ //banni
                    ban = "<i class='btn fas fa-user user' title='Remettre les droits de cet utilisateur par défaut'></i>";
                    color = "user_ban";
                }
                else if(user.rank==1){ //mod
                    mod = "<i class='btn fas fa-user user' title='Remettre les droits de cet utilisateur par défaut'></i>";
                    color = "user_mod";
                }
                else if(user.rank==2){ //streamer
                    mod = "";
                    ban = "";
                    color = "user_streamer";
                }
                text += ban+mod;
            }
            text += "<a href='"+environment+"/home/"+user.pseudo+"' target='_blank' class='btn "+color+"'>";
                text += "<img class='chat_avatar' src='"+environment+"/storage/"+user.avatar+"'> ";
                text += user.pseudo;
            text += "</a>";
        text += "</p>";
    });
    $('#zone_users span').html(text);
    searchingViewers();
});

//Changement du statut
$('#zone_users').on('click',".modo, .ban, .user", function(){
    var status = false;
    if($(this).hasClass('modo')){
        status = 1;
    }
    if($(this).hasClass('ban')){
        status = -1;
    }
    if($(this).hasClass('user')){
        status = 0;
    }
    
    var pseudo = $(this).parent().data('pseudo');
    socket.emit('editRank', status, pseudo);
});

//Recherche et affichage d'un membre parmi la liste de contact disponible
$("#search_contact").keyup(searchingViewers);
            
/* FONCTIONS */

//N'affiche que les viewers recherchés
function searchingViewers(){
    if($("#search_contact").val() == "")
        $("#zone_users .nav-link").show();
    else{
        $("#zone_users .nav-link").hide();
        $("#zone_users .nav-link[data-pseudo*='"+$("#search_contact").val()+"']").show();
    }
}

//Recupère les paramètres fournies dans l'URL
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

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
        
        $('#zone_chat').addClass('d-block').removeClass('d-none');
        $('#zone_users').addClass('d-none').removeClass('d-block');
    }//Description
    else{
        $('.sliderText[data-value="1"]').removeClass('font-weight-bold');
        $('.sliderText[data-value="2"]').addClass('font-weight-bold');
        
        $('#zone_chat').addClass('d-none').removeClass('d-block');
        $('#zone_users').addClass('d-block').removeClass('d-none');
    }
});