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

io.sockets.on('connection', function (socket) {
    
    // Dès qu'on nous donne un token : récupération de la liste des contacts
    socket.on('bringFriends', async function(token) {
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

                allClients.push(
                    {
                        socket_id: socket.id,
                        user_id: socket.user_id
                    }
                );
                
                console.log(allClients);
                checkFriends(socket);
            });
            
        //Nouveau message recus pour l'utilisateur
        await queryDB('UPDATE stb_messages SET status = 1 WHERE status = 2 AND user_receiv = ?', socket.user_id);
            
    });

    //Récupération d'une autre conversation
    socket.on('join', async function(friend) {

        await queryDB( //Recherche de l'utilisateur contacté
            `SELECT pseudo, avatar, id
                FROM users
                WHERE status > 0
                AND pseudo = ?`,
                friend)
            .then(function(row){
                socket.friend_pseudo = row.pseudo;
                socket.friend_id = row.id;
                socket.friend_avatar = row.avatar;
            });

        var conversations = [];

        await queryDB( //Recherche des messages entre les 2 utilisateurs
            `SELECT message, user_exped, user_receiv, created_at
                FROM stb_messages
                WHERE status >= 1
                AND (user_exped = ? OR user_receiv = ?)
                AND (user_exped = ? OR user_receiv = ?)`, 
                [socket.user_id, socket.user_id, socket.friend_id, socket.friend_id])
            .then(function(row){

                if(typeof row === 'undefined' || row.length == 0)
                    return new Error('user_missing');

                if(Array.isArray(row)){
                    row.forEach(function(element){
                        conversations.push({
                            message: element.message,
                            user_exped: (socket.user_id == element.user_exped) ? 'me' : 'friend',
                            user_receiv: (socket.user_id == element.user_receiv) ? 'me' : 'friend',
                            created_at: element.created_at
                        });
                    });
                }
                else{
                    conversations.push({
                        message: row.message,
                        user_exped: (socket.user_id == row.user_exped) ? 'me' : 'friend',
                        user_receiv: (socket.user_id == row.user_receiv) ? 'me' : 'friend',
                        created_at: row.created_at
                    });
                }
            });

        var infos = {
            friend_pseudo: socket.friend_pseudo,
            friend_avatar: socket.friend_avatar,
            user_avatar: socket.user_avatar,
            user_pseudo: socket.user_pseudo,
        };

        var datas = {
            infos: infos,
            conversations: conversations
        }
        socket.emit('join', datas);
        console.log("---- WELCOME ------");
    });
        

    // Message émis par l'utilisateur
    socket.on('message', async function (message) {
        message = ent.encode(message);
        content = { 
            user_exped: socket.user_id, 
            user_receiv: socket.friend_id, 
            message: message, 
            status: 2
        };

        var message = await queryDB('INSERT INTO stb_messages SET ?', content); //Sauvegarde en BDD
        content.user_exped_pseudo = socket.user_pseudo; //Ajout du pseudo de l'ami
        allClients.forEach(function(client, index) { //Diffusion du message à l'utilisateur regardant les messages
            if(client.user_id == socket.friend_id){
                io.to(client.socket_id).emit('message', content);
            }
        });
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

    socket.on('refresh', function(){
        if(socket.user_id)
            checkFriends(socket);
    });

    //Modification de la liste d'amis
    async function checkFriends(socket){
        await queryDB( //Recherche des utilisateurs followers au streamer
            `SELECT u_follower.id
                FROM users u_streamer
                LEFT OUTER JOIN stb_streams s ON u_streamer.id = s.streamer_id
                LEFT OUTER JOIN stb_viewers v ON s.id = v.stream_id
                LEFT OUTER JOIN users u_follower ON v.user_id = u_follower.id
                WHERE v.is_follower = 1
                AND u_follower.id <> u_streamer.id
                AND u_streamer.id = ?`,
                socket.user_id)
            .then(function(row){
                socket.list_followers = [];
                if(typeof row !== 'undefined'){
                    if(row.length > 1){
                        row.forEach(function(element){
                            socket.list_followers.push(element.id);
                        });
                    }
                    else
                        socket.list_followers = [row.id];
                }
            });
            
        await queryDB( //Liste des streamers followés par l'utilisateur
                `SELECT u_streamer.id
                    FROM users u_streamer
                    LEFT OUTER JOIN stb_streams s ON u_streamer.id = s.streamer_id
                    LEFT OUTER JOIN stb_viewers v ON s.id = v.stream_id
                    LEFT OUTER JOIN users u_follower ON v.user_id = u_follower.id
                    WHERE v.is_follower = 1
                    AND u_follower.id <> u_streamer.id
                    AND u_follower.id = ?`,
                    socket.user_id)
                .then(function(row){
                    socket.list_streamers = [];
                    if(typeof row !== 'undefined'){
                        if(row.length > 1){
                            row.forEach(function(element){
                                socket.list_streamers.push(element.id);
                            });
                        }
                        else
                            socket.list_streamers = [row.id];
                    }
                });
        
        //Selection des followers et streamers suivis mutuellement
        var list = socket.list_followers.concat(socket.list_streamers);
        var list_ord = list.slice().sort();

        var results = [];
        for (var i = 0; i < list_ord.length - 1; i++) {
            if (list_ord[i + 1] == list_ord[i]) {
                results.push(list_ord[i]);
                results.push(list_ord[i]);
            }
        }

        socket.contactList = [];
        if(typeof results !== 'undefined' && results.length > 0){
            await queryDB( //Liste des streamers followés par l'utilisateur
                "SELECT u.pseudo, u.avatar FROM users u WHERE u.id IN (?)",
                [results])
                .then(function(row){
                    if(typeof row !== 'undefined' && Array.isArray(row)){
                        if(row.length > 0){
                            if(row.length > 1){
                                row.forEach(function(element){
                                    socket.contactList.push({
                                        pseudo: element.pseudo,
                                        avatar: element.avatar
                                    });
                                });
                            }
                            else
                                socket.contactList = [{
                                    pseudo: row.pseudo,
                                    avatar: row.avatar
                                }];
                        }
                    }
                    else
                        socket.contactList = [{
                            pseudo: row.pseudo,
                            avatar: row.avatar
                        }];
                });
        }
        
        var content = {
            contactList: socket.contactList,
            user_pseudo: socket.user_pseudo,
            user_avatar: socket.user_avatar
        };
        socket.emit('bringFriends', content);
    }
});


//EXECUTION DE REQUETE SQL
async function queryDB(sql, value){
    return new Promise(function(resolve, reject){
        connection.query( sql, value, function(err, rows, fields){
            if(err){ 
                console.log(err);
            }

            //console.log("----RESULTATS DE LA REQUETE----");console.log(rows);
            if(typeof rows !== 'undefined' && rows.length > 0 && rows.length == 1)
                resolve(rows[0]);
            else
                resolve(rows);
        });
    });
}

server.listen(3001);