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

// Chargement de la page index.html
app.get('/', function (req, res) {
  res.sendfile(__dirname + '/index.html');
});

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
        socket.broadcast.emit('message', {pseudo: socket.pseudo, message: message});
    }); 
});

//DB Connection
connection.connect((err) => {
    if (err) throw err;
    console.log('Connected!');
});

//DB Read
connection.query('SELECT * FROM stb_chats', (err,rows) => {
    if(err) throw err;
  
    rows.forEach( (row) => {
        console.log(`${row.viewer_id} says ${row.message}`);
    });
});

//DB Insert
const chat = { viewer_id: 1, message: 'Salut' };
connection.query('INSERT INTO stb_chats SET ?', chat, (err, res) => {
  if(err) throw err;

  console.log('Last insert ID:', res.insertId);
});

//Db Update
connection.query(
    'UPDATE stb_chats SET message = ? Where ID = ?',
    ['Yo', 1],
    (err, result) => {
      if (err) throw err;
  
      console.log(`Changed ${result.changedRows} row(s)`);
    }
);

//Db Destroy
connection.query(
    'DELETE FROM stb_chats WHERE message = ?', ["Salut"], (err, result) => {
      if (err) throw err;
  
      console.log(`Deleted ${result.affectedRows} row(s)`);
    }
);

//Db End
connection.end((err) => {
    // The connection is terminated gracefully
    // Ensures all previously enqueued queries are still
    // before sending a COM_QUIT packet to the MySQL server.
});

server.listen(8080);
