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
    // Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
    socket.on('nouveau_client', function(pseudo) {
        pseudo = ent.encode(pseudo);
        socket.pseudo = pseudo;
        socket.broadcast.emit('nouveau_client', pseudo);
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('message', function (message) {
        message = ent.encode(message);
        viewer = getDB();
        content = { 
            viewer_id: 1, 
            pseudo: pseudo, 
            message: message, 
            status: 1
        };
        saveDB(content);
        socket.broadcast.emit('message', {pseudo: content.pseudo, message: content.message, status: content.status});
    }); 
});


//DB Read
function getDB(){
    connection.query('SELECT * FROM stb_chats', (err,rows) => {
        if(err) throw err;
    
        rows.forEach( (row) => {
            console.log(`${row.viewer_id} says ${row.message}`);
        });
        connection.end((err) => {});
    });
}

//DB Insert
function saveDB(content){
    const chat = { viewer_id: content.viewer_id, message: content.message, status: content.status };
    connection.query(
        'INSERT INTO stb_chats SET ?', 
        chat, 
        (err, res) => {
            if(err) throw err;

            console.log('Last insert ID:', res.insertId);
            connection.end((err) => {});
        }
    );
}

//Db Update
function updateDB(){
    connection.query(
        'UPDATE stb_chats SET message = ? Where ID = ?',
        ['Yo', 1],
        (err, result) => {
            if (err) throw err;
        
            console.log(`Changed ${result.changedRows} row(s)`);
            connection.end((err) => {});
        }
    );
}

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
