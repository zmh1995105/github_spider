"use strict";

var forIn = require('mout/object/forIn');

    //note that items are only replaced one time, use rreplaces if needed
module.exports = function(str, hash){
  forIn(hash, function(v, k){
    str = str.replace(k, v);
  });
  return str;
}
