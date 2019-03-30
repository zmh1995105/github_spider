"use strict";

var fs = require('fs');
var isDirectorySync = require('./isDirectorySync');

var self =  module.exports = function(file_path) {
    var files = [];
    if( fs.existsSync(file_path) ) {
        files = fs.readdirSync(file_path);
        files.forEach(function(file,index){
            var curfile_path = file_path + "/" + file;
            if(isDirectorySync(curfile_path)) { // recurse
                self(curfile_path);
            } else { // delete file
                fs.unlinkSync(curfile_path);
            }
        });
        fs.rmdirSync(file_path);
    }
};


