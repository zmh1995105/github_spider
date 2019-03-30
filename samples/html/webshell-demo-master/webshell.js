/**
 * Created by xuezhongxiong on 2017/4/19.
 */
'use strict';
const exec     = require('child_process').exec;
const readline = require('readline');

const ansiHTML = require('ansi-html');
const SocketIO = require('socket.io');

//存储所有stream的集合
const streamReaders = {};

module.exports = {watchFile, watchProcess, init};

function init(httpServer) {
  const io = SocketIO(httpServer);

  io.on('connection', function (socket) {

    socket.on('watchFile', file => {
      sub(watchFile(file));
    });

    function sub(id) {

      if (!streamReaders[id]) return socket.emit('line', `该订阅id不存在: ${id}`);

      //管道函数，收到流的line事件则将内容转成html格式然后触发客户端的line事件
      const pipe = line => socket.emit('line', ansiHTML(line));

      //历史输出
      streamReaders[id].lines.forEach(pipe);

      //订阅流的line事件
      streamReaders[id].on('line', pipe);

      //客户端断连时取消订阅事件
      socket.on('disconnect', () => {
        if (streamReaders[id]) streamReaders[id].removeListener('line', pipe);
      });
    }

    socket.on('sub', sub);
  });
}


/**
 * 用tail -f读文件
 * @param file
 * @return id
 */
function watchFile(file) {
  return listen(exec(`tail -n 100 -f ${file}`).stdout);
}

/**
 * 自定义的命令行，比如pm2 logs 0
 * @param cmd
 * @return id
 */
function watchProcess(cmd) {
  return listen(exec(cmd).stdout);
}

/**
 * 对流做一些额外处理
 * @param stream
 * @return id
 */
function listen(stream) {
  const id = Date.now();

  const rl = streamReaders[id] = readline.createInterface({input: stream});

  rl.lines = [];

  rl
    .on('line', line => {
      rl.lines.push(line);
      if (rl.lines.length > 100) rl.lines.shift();
    })
    .on('close', () => {
      rl.emit('line', 'stream is close.');
    });

  //定期检查这个reader有没有订阅者，没有就取消引用
  const intervalId = setInterval(() => {
    if (rl.listenerCount('line') === 0) {
      clearInterval(intervalId);
      delete streamReaders[id];
      rl.close();
    }
  }, 30 * 1000);

  return id;
}

//demo部分，加入伪时间流，定期输出当前时间
const EventEmitter = require('events').EventEmitter;
const timeEmitter  = new EventEmitter();
timeEmitter.lines  = [];
streamReaders.time = timeEmitter;

//定期触发line事件
setInterval(() => {
  timeEmitter.emit('line', new Date().toLocaleString());
}, 1000);