"use strict";

var path = require('path');

module.exports = function(npath){

  var paths = process.env.PATH.split(path.delimiter).concat([].slice.call(arguments));
  return process.env.PATH = paths.join(path.delimiter);
}