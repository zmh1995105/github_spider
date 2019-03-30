"use strict";

var util       = require('util');
var startsWith = require('mout/string/startsWith');
var isFinite   = require('mout/lang/isFinite');
var isArray    = require('mout/lang/isArray');

module.exports = function(argv){

  /* istanbul ignore if  */
  if(arguments.length == 0)
     argv = process.argv.slice(2);

  var args = [], dict = {},
      r, e = new RegExp("^--?([a-z_0-9/:-]+)(?:=(.*))?", "i");

  argv.forEach(function(arg){
    var k, v;
    if(!startsWith(arg, '-')) {
      args.push(arg);
    } else if(e.test(arg)) {
      r = e.exec(arg);
      k = r[1], v = r[2] === undefined ? true : r[2];

      if(isFinite(v))
        v = parseFloat(v);

      if(dict[k] !== undefined) {
        if(!isArray(dict[k]))
          dict[k] = [dict[k]];

        dict[k].push(v);
      } else dict[k] = v;
    }
  });

  return {args:args, dict:dict};
}
