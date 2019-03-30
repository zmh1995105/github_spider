define([
    'jquery',
    'underscore',
    'backbone',
    './libs/github'
], function ($, _, Backbone,Github) {

    var private_methods = {
        getRepo: function (token, user, repo) {
            var github = new Github({
                token: token
            });
            return github.getRepo(user, repo);
        }
    }

    var main = {
        init: function () {

        },
        getRepo: function (user, repo, callback) {

            if (SmartBlocks.Blocks.GithubBlock.Config.user_token) {
                var repos = private_methods.getRepo(SmartBlocks.Blocks.GithubBlock.Config.user_token, user, repo);
                callback(repos);
            } else {
                SmartBlocks.Blocks.WebshellBlock.Main.OAuth(function (token) {
                    SmartBlocks.Blocks.GithubBlock.Config.user_token = token;
                    var repos = private_methods.getRepo(SmartBlocks.Blocks.GithubBlock.Config.user_token, user, repo);
                    callback(repos);
                });
            }
        }
    };

    return main;
});