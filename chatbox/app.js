/* Constantes */
var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'); // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)
const mysql = require('mysql');

var bddLog = require('./bdd');
const config = bddLog.config;
const connection = mysql.createConnection(config);

const allClients = [];

/* Load */

app.use(express.static(__dirname + "/public"));

// Chargement de la page index.html
app.get('/', function (req, res) {
    //res.sendFile(__dirname + '/index.html');
    res.sendfile(__dirname + '/index.html');
});

//DB Connection
connection.connect((err) => {
    if (err) throw err;
    console.log('Connected!');
});

/* Ecoute */

io.sockets.on('connection', function (socket, pseudo) {
    
    // Dès qu'on nous donne un token, on le recherche dans la table session pour l'associer à un utilisateur
    socket.on('join', async function(token, streamer_name) {
        
        await queryDB( //Recherche du stream ciblé
            `SELECT s.id
                FROM stb_streams s
                LEFT OUTER JOIN users u ON s.streamer_id = u.id
                WHERE u.pseudo = ?`,
                streamer_name)
            .then(function(row){
                socket.stream_id = row.id;
            });
        
        
        await queryDB( //Recherche de l'utilisateur connecté
            `SELECT u.pseudo, u.id, u.avatar
                FROM sessions s
                LEFT OUTER JOIN users u ON s.user_id = u.id
                WHERE FROM_BASE64(s.payload) LIKE ?`, 
                '%'+token+'%')
            .then(function(row){
                if(typeof row === 'undefined' || row.length == 0)
                    return new Error('user_missing' );
                    
                socket.user_avatar = row.avatar;
                socket.user_id = row.id;
                socket.user_pseudo = row.pseudo;
            });

        
        await queryDB( //Association du user+stream au viewer correspondant
            `SELECT id, rank, is_follower
                FROM stb_viewers
                WHERE stream_id = ? 
                    AND user_id = ?`, 
                [socket.stream_id, socket.user_id])
            .then(async function(viewer){ //Si nouveau viewer pour le stream, on le répertorie
                if(viewer.length <= 0){
                    await queryDB(
                        `INSERT INTO stb_viewers
                            SET stream_id = ? ,
                            user_id = ?`,
                        [socket.stream_id, socket.user_id])
                        .then(async function(){
                            
                            await queryDB(
                                `SELECT id, rank, is_follower
                                    FROM stb_viewers
                                    WHERE stream_id = ? 
                                        AND user_id = ?`, 
                                    [socket.stream_id, socket.user_id])
                                .then(async function(viewer){
                                    socket.viewer_id = viewer.id;
                                    socket.viewer_rank = viewer.rank;
                                });
                        });
                }
                else{
                    socket.viewer_id = viewer.id;
                    socket.viewer_rank = viewer.rank;
                }
            });
        
        allClients.push(
            {
                socket_id: socket.id,
                stream_id: socket.stream_id,
                user_id: socket.user_id,
                user_pseudo: socket.user_pseudo,
                user_avatar: socket.user_avatar,
                viewer_rank: socket.viewer_rank
            }
        );

        console.log("---- WELCOME ------");
        console.log(allClients); 
        socket.emit('welcome');
        
        checkViewers(socket);
        setInterval(function(){
            checkViewers(socket);
        }, 2000);
    });
        
    // Envoi d'un message
    socket.on('message', async function (message) {
        updateViewer(socket, allClients);
        if(socket.viewer_rank >= 0){ //Vérification du statut
            message = ent.encode(message);
            content = { 
                viewer_id: socket.viewer_id, 
                message: message, 
                status: 1
            };
            
            var message = await queryDB('INSERT INTO stb_chats SET ?', content); //Sauvegarde en BDD

            
            allClients.forEach(function(client, index) { //Diffusion du message
                if(client.stream_id == socket.stream_id){ // aux utilisateurs visionnant le stream
                    var datas = {
                        pseudo: socket.user_pseudo, 
                        avatar: socket.user_avatar,
                        message: content.message, 
                        status: content.status,
                        viewer_rank: socket.viewer_rank,
                        message_id: message.insertId,
                    };
                    console.log(datas);
                    if(client.viewer_rank!=0) //Indicateur supplémentaire pour les modos/admin
                        datas.admin = 1;

                    io.to(client.socket_id).emit('message', datas);
                }
            });
        }
        else{//Bannissement
            io.to(socket.id).emit('ban');
        }
    }); 

    //Modération d'un message
    socket.on('delete', function(message_id){
        updateViewer(socket, allClients);
        if(socket.viewer_rank >= 1){ //Vérification du statut
            queryDB('UPDATE stb_chats SET status = 0 WHERE id = ?', message_id);

            //Envoi du message aux utilisateurs connectés sur le même stream
            allClients.forEach(function(client, index) {
                if(client.stream_id == socket.stream_id)
                    io.to(client.socket_id).emit('delete', message_id);
            });
        }
        else{//Bannissement
            io.to(socket.id).emit('demod');
        }
    });

    //Changement du statut
    socket.on('editRank', function(status, pseudo){
        updateViewer(socket, allClients);
        if(status !== false && socket.viewer_rank>=1){ //Vérification du statut du staff
            allClients.forEach(function(element){
                if(element.user_pseudo == pseudo){
                    queryDB(
                        'UPDATE stb_viewers SET rank = ? WHERE user_id = ? AND stream_id = ?', 
                        [status, element.user_id, element.stream_id]
                    );
                    element.viewer_rank = status;
                }
            });
        }
        updateViewer(socket, allClients);
    });

    //Déconnexion d'un utilisateur
    socket.on('disconnect', function(){
        var i = allClients.findIndex(findSocket);
        if(i>-1)
            allClients.splice(i, 1);
        console.log("---- BYE ------");
        console.log(allClients);
    });
    
    function findSocket(element){
        return element.socket_id == socket.id;
    }

    //Dons
    async function checkDonations(socket){
        //Recherche du stream ciblé
        if(socket && typeof socket.last_donation == "undefined")
            socket.last_donation = 0;

        var date = new Date().toISOString().replace(/T/, ' ').replace(/\..+/, '');

        if(socket && typeof socket.stream_id != "undefined"){
            await queryDB( 
                `SELECT i.*, u.pseudo
                    FROM stb_invoices i
                    LEFT OUTER JOIN stb_viewers v ON i.viewer_id = v.id
                    LEFT OUTER JOIN users u ON v.user_id = u.id
                    WHERE v.stream_id = ?
                    AND i.id > ?
                    AND i.created_at >= ?
                    ORDER BY i.id ASC
                    LIMIT 1`, 
                    [socket.stream_id, socket.last_donation, date])
                .then(function(row){

                    if(row.id != "undefined" && row.id > socket.last_donation){
                        socket.last_donation = row.id;
                        socket.emit('dons', row);
                    }
                });
        }
    }
    setInterval(function(){checkDonations(socket)}, 1000);

    //Modification de la liste de viewers
    async function checkViewers(socket){
        updateViewer(socket, allClients);
        var tab = allClients.sort(function(a,b){
            if(a.user_pseudo < b.user_pseudo) return -1;
            if(a.user_pseudo > b.user_pseudo) return 1;
            return 0;
        });

        var viewers = [];

        tab.forEach(function(element){
            if(element.stream_id == socket.stream_id){
                //Si le viewer est un modo / streamer
                var staff = (socket.viewer_rank>=1);
                viewers.push({
                    pseudo: element.user_pseudo,
                    rank: element.viewer_rank,
                    avatar: element.user_avatar,
                    is_staff: staff
                });
            }
        });

        socket.emit('updateList', viewers);
    }

    function updateViewer(socket, allClients){
        /*
            {
                socket_id: socket.id,
                stream_id: socket.stream_id,
                user_id: socket.user_id,
                user_pseudo: socket.user_pseudo,
                user_avatar: socket.user_avatar,
                viewer_rank: socket.viewer_rank
            }
        */
        allClients.forEach(function(element){
            if(socket.user_id == element.user_id){
                socket.stream_id = element.stream_id;
                socket.viewer_rank = element.viewer_rank;
            }
        });
    }
});


//EXECUTION DE REQUETE SQL
async function queryDB(sql, value){
    return new Promise(function(resolve, reject){
        connection.query( sql, value, function(err, rows, fields){
            if(err){ 
                console.log(err);
            }

            //console.log("----RESULTATS DE LA REQUETE----");
            if(typeof rows !== 'undefined' && rows.length > 0 && rows.length == 1)
                resolve(rows[0]);
            else
                resolve(rows);
        });
    });
}

server.listen(3000);