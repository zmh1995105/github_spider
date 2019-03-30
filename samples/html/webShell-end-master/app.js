var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var path = require('path');
const exec = require('child_process').exec;
var jwt = require('jsonwebtoken');
var socketioJwt = require('socketio-jwt');
var bodyParser = require('body-parser');

var fs = require('fs');
var https = require('https');

app.use(bodyParser.urlencoded({ extended: false }));

app.set('view engine', 'ejs');

app.get('/',function(req,res){
    res.render('index');
});

app.get('/login', function (req, res) {
    res.render('login');
});

// TO DO : mettre en place https

app.post('/login', function (req, res,next) {
    // TODO: validate the actual user us
    var profile = {
        username: 'John',
        password: 'Doe'
    };
    // we are sending the profile in the token
    var token = jwt.sign(profile, 'secret-user', { expiresIn : 1440 });
    console.log(token);
    res.json({token: token});
});




io.sockets.on('connection',function(socket){

    socket.emit('message', 'Vous êtes bien connecté !');

    socket.on('command',function(data){
        console.log("Ligne de commande enter : " + data);

        exec(data, (error, stdout, stderr) => {
            if (error) {
                console.error(`exec error: ${error}`);
                socket.emit('output', `${error}`);
                return;
            }
            console.log(`stdout: ${stdout}`);
            console.log(`stderr: ${stderr}`);
            socket.emit('output', `${stdout}`, `${stderr}`); // renvoyer l'erreur aussi et coté client faire  un check error ou non et renvoyer si besoin

        });
    });


});


//check si le token cote client est bon
io.sockets
    .on('connection', socketioJwt.authorize({
        secret: 'secret-user',
        timeout: 15000 // 15 seconds to send the authentication message
    })).on('authenticated', function(socket) {
    //this socket is authenticated, we are good to handle more events from it.
    console.log('hello! ' + socket.decoded_token.username);
});





http.listen(3000, function(){
    console.log('listening on *:3000');
});
