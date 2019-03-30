"use strict";

var fs   = require('fs');
var path = require('path');

var mkdirpsync = module.exports = function(file_path){
  if( fs.existsSync(file_path) ) 
    return file_path;

  mkdirpsync(path.dirname(file_path));
  fs.mkdirSync(file_path);
  return file_path;
}