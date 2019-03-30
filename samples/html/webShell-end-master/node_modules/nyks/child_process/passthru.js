"use strict";

var cp = require('child_process');

  //callback(err, exit, lastline);
module.exports = function(cmd, options, chain){
  if(Array.isArray(options))
    options = { args : options} ;

  options = options || {};
  options.stdio = ['inherit', 'inherit', 'inherit'];

  var ps   = cp.spawn(cmd, options.args || [], options);

  ps.on('error', function(err){
    ps.removeAllListeners('close');
    ps.on('close', function(exit) {
      return chain(err, exit);
    });
  });

  ps.on('close', function(exit) {
    var err = null;
    if(exit !== 0)
      err = "Bad exit code " + exit;
    return chain(err, exit);
  });
}

