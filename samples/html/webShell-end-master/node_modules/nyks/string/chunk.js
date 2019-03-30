"use strict";

module.exports = function(str, chunkSize){
  if(chunkSize <= 0)
    return [str];

  var chunks = []; chunkSize = chunkSize || 1;
  while (str) {
    if (str.length < chunkSize) {
        chunks.push(str);
        break;
    }
    else {
        chunks.push(str.substr(0, chunkSize));
        str = str.substr(chunkSize);
    }
  }
  return chunks;

}

