"use strict";

var cp = require('child_process');


  //callback(err, exit, lastline);
module.exports = function(cmd, options, chain){
    if(Array.isArray(options))
      options = { args : options} ;
    options = options || {};

  var ps   = cp.spawn(cmd, options.args || [], options),
      _stdout = "", _stderr = "";

  ps.on('error', function(err){
    ps.removeAllListeners('close');
    ps.on('close', function(exit) {
      return chain(err);
    });
  });

  ps.stdout.on("data", function(data){ _stdout += data; });
  ps.stderr.on("data", function(data){ _stderr += data; });

  ps.on('close', function(exit) {
    return chain(exit, _stdout, _stderr);
  });

  return ps;
}

