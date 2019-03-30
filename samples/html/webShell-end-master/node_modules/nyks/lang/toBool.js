"use strict";
var kindOf = require('mout/lang/kindOf');


module.exports = function(str) {
  if(kindOf(str) == "String")
    return str && str != "false" && str != "no" && str != "n" && str != "f" && str != "0";
  return !!str;
}

