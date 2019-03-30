var readFolderRecursive = require("./walkFolderStatsRecursive");

module.exports = function(dir_path, callback){
  var size = 0 ;
  readFolderRecursive(dir_path, function(fileStat){
    size += fileStat.size;
  }, function(){
    callback(null, size);
  })
}
