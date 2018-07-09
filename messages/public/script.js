var options = {
    year: 'numeric', 
    month: 'numeric', 
    day: 'numeric', 
    hour: 'numeric', 
    minute:'numeric'
};
var currentDate = new Date();

/* ENVOI */

// Connexion à socket.io
var socket = io.connect('http://'+window.location.hostname+':3001');
var token = getUrlParameter('token');

// Affichage de la liste des contacts mutuels
socket.emit('bringFriends', token);
socket.on('bringFriends', function(data) {
    var text = "";
    $.each(data, function(index, value){
        text += "<a class='nav-link text-center' data-pseudo='"+value+"' data-toggle='pill' href='#' role='tab' aria-selected='false'>";
            text += value;
        text += "</a>";
    });
    if(text=="")
        text = "<p>Aucun contact de joignable.</p>";
    $('#listContacts').html(text);
});

//Changement de conversation
$('#listContacts').on("click", ".nav-link", function(){
    $(".nav-link").removeClass("active show").prop("aria-selected", false);
    var friend = $(this).data('pseudo');
    socket.emit('join', friend);
});
socket.on('join', function(data) {
    var infos = data.infos;
    var port = (window.location.hostname == "localhost") ? ":8000" : "";
    $("#profile_img").prop("src", "http://"+window.location.hostname+port+"/storage/"+infos.friend_avatar);
    $("#profile_pseudo").prop("href", "http://"+window.location.hostname+port+"/stream/"+infos.friend_pseudo);
    $("#profile_pseudo span").html(infos.friend_pseudo);

    var conversations = data.conversations;
    var text = "";
    $.each(conversations, function(index, element){
        var message = "<p ";
            message += (element.user_exped == "me") ? "class='row col-8 offset-4'" : "class='row col-8'";
            message += ">";
            message += "<span class='col-12 message'>"+element.message+"</span>";
            var messageDate = new Date(element.created_at);
            message += "<span class='col-12 date text-light h6'>"+messageDate.toLocaleDateString('fr-FR', options)+"</span>";
        message += "</p>";
        text += message;
    });
    $("#zone_chat").html(text);
    $("#zone_chat").animate({ scrollTop: $("#zone_chat")[0].scrollHeight }, 100);

    $("#none").removeClass("d-flex").addClass("d-none");
    $("#profile").removeClass("d-none").addClass("d-flex");
    $("#formulaire_chat input").prop("disabled", false);
    $("#formulaire_chat textarea").prop("disabled", false).prop("placeholder", "Saisissez ici votre message");
});

// Quand on envoie un message, on l'insère dans la page
$('#formulaire_chat').submit(function (event) {
    event.preventDefault();
    var message = $('#message').val();

    if(message != ""){
        var content = "<p class='row col-8 offset-4'>";
                content += "<span class='col-12 message'>"+message+"</span>";
                content += "<span class='col-12 date text-light h6'>"+currentDate.toLocaleDateString('fr-FR', options)+"</span>";
        content += "</p>";
        $("#zone_chat").append(content);
        socket.emit('message', message); // Publie le message
    }

    $('#message').val('').focus(); // Vide la zone de Chat et remet le focus dessus
    $("#zone_chat").animate({ scrollTop: $("#zone_chat")[0].scrollHeight }, 100);
    return false; // Permet de bloquer l'envoi "classique" du formulaire
});

// Quand on recoit un message, on l'insère dans la page
socket.on('message', function(message) {
    if(message){
        var content = "<p class='justify-content-start'>";
            content += "<span class='message'>"+message+"</span>";
            content += "<span class='date'>"+currentDate.toLocaleDateString('fr-FR', options)+"</span>";
        content += "</p>";
        $("#zone_chat").append(content);
    }
    $("#zone_chat").animate({ scrollTop: $("#zone_chat")[0].scrollHeight }, 100);
});

//Recherche et affichage d'un membre parmi la liste de contact disponible
$("#search_contact").keyup(function(){
    if($(this).val() == "")
        $("#listContacts a.nav-link").show();
    else{
        $("#listContacts a.nav-link").hide();
        $("#listContacts a.nav-link[data-pseudo*='"+$(this).val()+"']").show();
    }
});

/* FONCTIONS */

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
        
        $('#searchContacts').addClass('d-block').removeClass('d-none');
        $('#user_section').addClass('d-none').removeClass('d-block');
    }//Description
    else{
        $('.sliderText[data-value="1"]').removeClass('font-weight-bold');
        $('.sliderText[data-value="2"]').addClass('font-weight-bold');
        
        $('#searchContacts').addClass('d-none').removeClass('d-block');
        $('#user_section').addClass('d-block').removeClass('d-none');
    }
});