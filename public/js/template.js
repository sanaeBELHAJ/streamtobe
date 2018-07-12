$(function () {
    //CSRF Protection
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    //Recherche d'utilisateurs
    $(".searchUser").each(function(){
        $(this).autocomplete({
            source: "/autocomplete",
            minLength: 2,
            select: function(event, ui) {
                $(this).val(ui.item.value);
                var action = $(this).data('action');

                if(action == "redirect")
                    window.location.replace("/home/"+ui.item.value);
                else if(action == "ban" || action == "mod")
                    statusViewer(ui.item.value, action, 1); //Fonction appelée dans stream.show
            }
        })
        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "ui-autocomplete-item", item )
                .append("<img class='results_picture' src='"+item.avatar+"'> "+item.value )
                .appendTo( ul );
        };
    });
    
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

    //Validation cookie
    $('#valid_cookie').click(function(){
        $.ajax({
            url: "/valid_cookie",
            type: 'POST'
        })
        .done(function(data){
            $("#cookies").hide();
        })
        .fail(function(data){
            console.log(data);
        });
    });

    //Support utilisateur
    $('#support_user').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: "/support",
            type: 'POST',
            dataType: 'JSON',
            data: {
                exped: $("[name='exped']").val(),
                opinion: $("[name='opinion']").val()
            }
        })
        .done(function(data){
            $("[name='opinion']").val('');
            $("#support_user .alert-success").removeClass('d-none').addClass('d-block');
            $("#support_user .alert-danger").removeClass('d-block').addClass('d-none');
        })
        .fail(function(data){
            $("#support_user .alert-success").removeClass('d-block').addClass('d-none');
            $("#support_user .alert-danger").removeClass('d-none').addClass('d-block');
            console.log(data);
        });
        return false;
    });

    /* Buttons de follow de stream (pour viewer) */
    $(".follow_stream").click(function(){
        var following = $(this).data('value');
        var streamer = $(this).data('streamer');
        $.ajax({
            url: "/followStream",
            type: 'POST',
            data: {
                stream: streamer,
                is_following: following
            }
        })
        .done(function(data){
            if(data == 0){
                $(".follow_stream[data-value='1']").removeClass("d-none");
                $(".follow_stream[data-value='0']").addClass("d-none");
            }
            else{
                $(".follow_stream[data-value='0']").removeClass("d-none");
                $(".follow_stream[data-value='1']").addClass("d-none");
            }
        })
        .fail(function(data){
            console.log(data);
        });
    });
});