"use strict";

var fs = require('fs'),
  crypto = require('crypto');


module.exports = function(file_path){
  var md5 = crypto.createHash('md5');
  md5.update(fs.readFileSync(file_path));
  return md5.digest('hex');
}
