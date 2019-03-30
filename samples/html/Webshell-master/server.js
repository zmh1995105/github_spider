var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
const exec = require('child_process').exec;
var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var jwt    = require('jsonwebtoken'); // used to create, sign, and verify tokens
var bodyParser  = require('body-parser');

var socketioJwt   = require("socketio-jwt");

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.use("/", express.static(__dirname + "/public"));



io.sockets
    .on('connection', socketioJwt.authorize({
        secret: 'config-secret',
        timeout: 15000 // 15 seconds to send the authentication message
    })).on('authenticated', function(socket) {
    console.log(socket);
    //this socket is authenticated, we are good to handle more events from it.
    console.log('hello! ' + socket.decoded_token.username);
});

app.post('/login', function (req, res) {
    var profile = {
        username: 'guillaume'
    };

    // we are sending the profile in the token
    // create a token
    var token = jwt.sign(profile, 'config-secret', {
        expiresIn: 1440 // expires in 24 hours
    });

    console.log(token);
    res.json({token: token});
});





io.on('connection', function(socket){

    socket.on('command',function(data){
        console.log("Ligne de commande enter : " + data);

        exec(data, (error, stdout, stderr) => {
            if (error) {
                socket.emit('output', `${error}`);
                return;
            }
            console.log(stdout);
            socket.emit('output', `${stdout}`, `${stderr}`);
        });
    });
});


http.listen(3000, function () {
    console.log('listening on *:3000');
});
