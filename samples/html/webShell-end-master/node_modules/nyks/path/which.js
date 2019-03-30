"use strict";

var fs   = require('fs');
var path = require('path');

module.exports = function(bin){
  var binpath;
  var paths = process.env.PATH.split(path.delimiter);
  /*istanbul ignore next*/
  var exts  = process.env.PATHEXT ? process.env.PATHEXT.split(path.delimiter) : [""];

  exts = exts.filter(function(val){
    return !!val;
  });
  exts.push(""); //handle direct bin calls

  for(var i = 0; i <paths.length; i++) {
    var ext, _full, full = path.join(paths[i], bin);
    for(ext = 0; ext < exts.length; ext++) {
      _full = full + exts[ext];
      if(fs.existsSync(_full))
        return _full;
    }
  };
  return false;
};
