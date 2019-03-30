define([
    'jquery',
    'underscore',
    'backbone',
    './libs/oauthio',
    'http://api.webshell.io/sdk/js?key=' + SmartBlocks.Blocks.WebshellBlock.Config.api_key
], function ($, _, Backbone) {
    OAuth.initialize('xHZzysJg1RKVy0r7UjbysScXiMI');
    var Main = {

        init: function () {

        },
        exec: function (obj) {
            if (wsh && obj.code && obj.process) {
                wsh.exec({
                    code: obj.code,
                    args: obj.args,
                    process: obj.process
                });
            }
        },
        OAuth: function (callback) {
            OAuth.popup('github', function(error, result) {
                //handle error with error
                //use result.access_token in your API request
                callback(result.access_token);
//                console.log(error, result);
            });
        }
    };

    return Main;
});