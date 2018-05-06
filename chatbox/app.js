/* Constantes */
var app = require('express')(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'), // Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)
    fs = require('fs');

const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'streamtobe'
});

/* Load */

// Chargement de la page index.html
app.get('/', function (req, res) {
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
    socket.on('nouveau_client', function(token) {
        connection.query(
            `SELECT u.pseudo, v.id 
                FROM sessions s, users u, stb_viewers v 
                WHERE u.id = v.user_id 
                    AND s.user_id = u.id
                    AND FROM_BASE64(s.payload) LIKE ?`, 
            '%'+token+'%', 
            function(err, res){
                console.log("----NOUVEAU----");
                console.log(res);
                if(err){ 
                    console.log(err);
                }
                
                if(typeof res !== 'undefined' && res.length > 0){
                    socket.pseudo = ent.encode(res[0].pseudo);
                    socket.user_id = res[0].id;
                    socket.emit('nouveau_client', socket.pseudo);
                }
                else{
                    console.log("----ERREUR---- : Pas de session");
                    socket.emit('erreur', "Session introuvable");
                }
            }
        );
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('message', function (message) {
        message = ent.encode(message);
        content = { 
            viewer_id: socket.user_id, 
            message: message, 
            status: 1
        };
        saveDB(content);
        socket.emit('message', {pseudo: socket.pseudo, message: content.message, status: content.status});
    }); 
});

//DB Read
/*
function getDB(){
    connection.query('SELECT * FROM stb_chats', (err,rows) => {
        if(err) 
            console.log(err);
    
        if(typeof res !== 'undefined' && res.length > 0){
            rows.forEach( (row) => {
                console.log(`${row.viewer_id} says ${row.message}`);
            });
        }
        else{
            console.log("----ERREUR---- : Pas de message");
        }
        connection.end((err) => {});
    });
}*/

//DB Insert
function saveDB(content){
    // const chat = { 
    //     viewer_id: content.viewer_id, 
    //     message: content.message, 
    //     status: content.status 
    // };
    console.log("----CONTENU----");
    console.log(content);

    connection.query(
        'INSERT INTO stb_chats SET ?', 
        content, 
        (err, res) => {
            if(err) 
                console.log(err);
                //throw err;

            //console.log('Last insert ID:', res.insertId);
            //connection.end((err) => {});
        }
    );
}

//Db Update
/*
function updateDB(){
    connection.query(
        'UPDATE stb_chats SET message = ? Where ID = ?',
        ['Yo', 1],
        (err, result) => {
            //if (err) throw err;
        
            console.log(`Changed ${result.changedRows} row(s)`);
            connection.end((err) => {});
        }
    );
}*/

//Db Destroy
/*
function destroyDB(){
    connection.query(
        'DELETE FROM stb_chats WHERE message = ?', 
        ["Salut"], 
        (err, result) => {
            if (err) throw err;
        
            console.log(`Deleted ${result.affectedRows} row(s)`);
            connection.end((err) => {});
        }
    );
}
*/

server.listen(8080);
