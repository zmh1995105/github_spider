"use strict";

var fs = require('fs');

module.exports = function(file_path){
 return fs.existsSync(file_path) && fs.statSync(file_path).isDirectory();
}
