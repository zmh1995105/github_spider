"use strict";

var str_chunk = require('../string/chunk');

module.exports = function(str, armor){
  if(Buffer.isBuffer(str))
      str = str.toString('base64');

  str = [].concat(["-----BEGIN "+armor+"-----"], str_chunk(str, 64), ["-----END "+armor+"-----"]);
  str = str.join("\n");
  return str;
}