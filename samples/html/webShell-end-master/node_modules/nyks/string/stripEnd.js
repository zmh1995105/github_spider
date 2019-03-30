"use strict";

var endsWith = require('mout/string/endsWith');

module.exports = function(str, end){
  return endsWith(str, end) ? str.substr(0, str.length - end.length) : str.toString();
}
