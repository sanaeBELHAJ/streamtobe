/* Constantes */
var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'); // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)
    

const mysql = require('mysql');

const config = {
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'streamtobe'
};
const connection = mysql.createConnection(config);


const allClients = [];

/* Load */

app.use(express.static(__dirname + "/public"));

// Chargement de la page index.html
app.get('/', function (req, res) {
    res.sendFile(__dirname + '/index.html');
});

//DB Connection
connection.connect((err) => {
    if (err) throw err;
    console.log('Connected!');
});

/* Ecoute */

io.sockets.on('connection', function (socket, pseudo) {
    
    // Dès qu'on nous donne un token, on le recherche dans la table session pour l'associer à un utilisateur
    socket.on('join', async function(token, friend) {

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

        var conversations = [];
        
        //console.log("USER : "+socket.user_id);
        //console.log("FRIEND : "+socket.friend_id);

        await queryDB( //Recherche des messages entre les 2 utilisateurs
            `SELECT message, user_exped, user_receiv, created_at
                FROM stb_messages
                WHERE status = 1
                AND (user_exped = ? OR user_receiv = ?)
                AND (user_exped = ? OR user_receiv = ?)`, 
                [socket.user_id, socket.user_id, socket.friend_id, socket.friend_id])
            .then(function(row){
                if(typeof row === 'undefined' || row.length == 0)
                    return new Error('user_missing' );
                
                row.forEach(function(element){
                    conversations.push({
                        message: element.message,
                        user_exped: element.user_exped,
                        user_receiv: element.user_receiv,
                        created_at: element.created_at
                    });
                });
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
        console.log(datas);
        socket.emit('join', datas);
        console.log("---- WELCOME ------");
    });
        
    
    // Réception d'un message
    socket.on('message', async function (message) {
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

});


//EXECUTION DE REQUETE SQL
async function queryDB(sql, value){
    return new Promise(function(resolve, reject){
        connection.query( sql, value, function(err, rows, fields){
            if(err){ 
                console.log(err);
            }

            //console.log("----RESULTATS DE LA REQUETE----");
            //console.log(rows);
            if(typeof rows !== 'undefined' && rows.length > 0 && rows.length == 1)
                resolve(rows[0]);
            else
                resolve(rows);
        });
    });
}

server.listen(3000);