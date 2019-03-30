"use strict";

// http://stackoverflow.com/q/617647
module.exports = function(str) {
  return str.replace(/[a-zA-Z]/g, function(a){
      return String.fromCharCode( ((a=a.charCodeAt())<91?78:110)>a ? a+13 : a-13 );
  });
}
