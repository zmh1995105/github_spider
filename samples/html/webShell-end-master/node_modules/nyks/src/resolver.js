"use strict";

var  url   = require('url'),
     path   = require('path');

var Resolver = module.exports = new Class({
  stack : {},
  register:function(prefix, dest){
    this.stack[prefix] = { dest: dest };
  },

  resolve:function(raw){
    if(!raw.startsWith("path://"))
      return raw;
    var parsed = url.parse(raw);
    if(! (parsed.host in this.stack))
      throw "Unregistered path : path://" + parsed.host;
    return path.join(this.stack[parsed.host].dest, parsed.path);
  }
});
