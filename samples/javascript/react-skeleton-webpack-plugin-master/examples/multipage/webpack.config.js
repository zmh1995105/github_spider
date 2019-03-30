/**
 * @file skeleton conf
 * @author panyuqi (pyqiverson@gmail.com)
 */

/* eslint-disable fecs-no-require */

'use strict';

const path = require('path');
const utils = require('./utils');
const merge = require('webpack-merge');
const baseWebpackConfig = require('./webpack.base.conf');
const MultipageWebpackPlugin = require('multipage-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

const SkeletonWebpackPlugin = require('../../src');

function resolve(dir) {
    return path.join(__dirname, dir);
}

let webpackConfig = merge(baseWebpackConfig, {
    module: {
        rules: utils.styleLoaders({
            sourceMap: false,
            extract: true
        })
    },
    devtool: false,
    plugins: [

        new ExtractTextPlugin({
            filename: utils.assetsPath('css/[name].css')
        }),

        new SkeletonWebpackPlugin({
            webpackConfig: require('./webpack.skeleton.conf'),
            quiet: true
        }),

        new MultipageWebpackPlugin({
            bootstrapFilename: 'manifest',
            templateFilename: '[name].html',
            templatePath: resolve('dist'),
            htmlTemplatePath: resolve('./index.html'),
            htmlWebpackPluginOptions: {
                inject: true
            }
        })
    ]
});

module.exports = webpackConfig;
