"use strict";

var fs = require('fs'),
  crypto = require('crypto');


module.exports = function (file_path, callback){
  var shasum = crypto.createHash('md5');
  var s = fs.ReadStream(file_path);
  s.on('data', shasum.update.bind(shasum));
  s.on('end', function() {
    callback(null, shasum.digest('hex'));
  });
}
