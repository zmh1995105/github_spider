/**
 * Created by xuezhongxiong on 2017/4/19.
 */
'use strict';
const fs       = require('fs');
const http     = require('http');
const webShell = require('./webshell');

const server = http
  .createServer((req, res) => {
    res.end(fs.readFileSync('./webshell.html'));
  })
  .on('listening', () => {
    console.log('listen on http://localhost:8888');
  })
  .listen(8888);

webShell.init(server);