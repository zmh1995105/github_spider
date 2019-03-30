/**
 * Created by pyfeng on 2016/9/29.
 */

var rf = require("fs");
rf.readFile('C:/Users/Administrator/Desktop/chap-secrets', 'utf-8', function (err, data) {
    if (err) {
        console.log("error");
    }
    else {
        var accounts = data.split('\n');
        accounts.shift();
        accounts.shift();
        accounts.pop();
        accounts.forEach(function(line){
            var columns = line.split('\t');
            console.log(columns);
            var username = columns[0];
            var password = columns[2];
            var ip = columns[3];

        });
    }
});