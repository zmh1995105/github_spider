
/**
 * Module dependencies.
 */

var express = require('express');
var routes = require('./routes');
var user = require('./routes/user');
var http = require('http');
var path = require('path');

var app = express();

// all environments
app.set('port', process.env.PORT || 9000);
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(express.favicon());
app.use(express.logger('dev'));
app.use(express.json());
app.use(express.urlencoded());
app.use(express.methodOverride());
app.use(app.router);
app.use(express.static(path.join(__dirname, 'public')));

var child_process=require('child_process');

var exec = child_process.exec;
var spawn = child_process.spawn;
var socketio=require('socket.io');
// development only
//if ('development' == app.get('env')) {}

app.use(express.errorHandler());

app.get('/', function(req,res){
   res.send("/")
});

app.get('/users', function(req,res){
   res.send("users");
});

var httpServer=http.createServer(app);

httpServer.listen(app.get('port'), function()
{
  console.log('Express server listening on port ' + app.get('port'));
});

var io = socketio.listen(httpServer);

//io.set('transports', ['xhr-polling']);
/*
io.configure('production', function(){
  //io.enable('browser client etag');
  io.set('log level', 2);
});

io.configure('development', function(){
  io.set('log level', 2);
});
*/

io.sockets.on('connection',function(socket)
{
    //var address = socket.handshake.address; 
    socket.on("cmd",function(data)
    {
        data=data.replace(/^\s+/g,"");
        data=data.replace(/\s+$/g,"");
        var A=data.split(/\s+/g);
        var L=A.length;
        if(L==1)
        {
           SpawnCmd(A[0],"",socket);
        }
        else
        {
           var args=[];
           for(var i=1;i<=L-1;i++)
           {
              args.push(A[i]);
           }
           console.log("args=");
           console.log(args);
           SpawnCmd(A[0],args,socket);          
        }
    });
});


function SpawnCmd(cmd,args,socket)
{
    var command  = spawn(cmd, args);
    var stdout=[];
    var stderr=[];

    command.stdout.on('data', function (data) {
       var bak=(data+"").replace(/\s+/g,"");
       if(bak==""){return}
        //console.log('stdout: ' + data+"123");
        if((data+"").match(/\n/g))
        {
          stdout.push(data);
          var str=stdout.join(" ");
          str=str.replace(/\n$/g,"");
          stdout=[];
          console.log(str);
          socket.emit("cmdecho",str);
        }
        else
        {
          stdout.push(data);
        }
    });

    command.stderr.on('data', function (data) {
        var bak=(data+"").replace(/\s+/g,"");
        if(bak==""){return}
        if((data+"").match(/\n/g))
        {
          stderr.push(data);
          var str=stderr.join(" ");
          str=str.replace(/\n$/g,"");
          stderr=[];
          console.log(str);
          socket.emit("cmdecho",str);
        }
        else
        {
          stderr.push(data);
        }
    });

    command.on('close', function (code) {
      console.log('child process exited with code ' + code);
      socket.emit("cmdclose",code);
    });
}




