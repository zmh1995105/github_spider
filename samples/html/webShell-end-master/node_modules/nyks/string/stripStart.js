"use strict";

var startsWith = require('mout/string/startsWith');

module.exports = function(str, start){
  return startsWith(str, start) ? str.substr(start.length) : str.toString();
}
