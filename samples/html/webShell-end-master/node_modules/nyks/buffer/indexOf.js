"use strict";

var indexOfc = function(buf, chr, offset, stop) {
  for (var i = offset||0; i < stop ; i++)
   if(buf[i] ==chr) return i;
  return -1;
}



module.exports = function(buf, search, offset, stop) {
  stop   = Math.min(stop || buf.length, buf.length);

  if(typeof search == "string")
    search = new Buffer(search);
  else if(typeof search == "number")
    return indexOfc(buf, search, offset, stop);

  offset = offset ||0;

  var m = 0;
  var s = -1;


  for(var i=offset; i< stop; ++i) {
    if(buf[i] == search[m]) {
      if(s == -1) s = i;
      ++m;
      if(m == search.length)
        return s;
    } else {
      s = -1;
      m = 0;
    }
  }

  return -1;
}
