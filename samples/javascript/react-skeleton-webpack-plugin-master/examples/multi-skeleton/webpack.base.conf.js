/**
 * @file base conf
 * @author panyuqi (pyqiverson@gmail.com)
 */

'use strict';

const utils = require('./utils');
const path = require('path');

function resolve(dir) {
    return path.join(__dirname, dir);
}

module.exports = {
    entry: {
        app: resolve('./src/entry.js')
    },
    output: {
        path: resolve('dist'),
        filename: utils.assetsPath('js/[name].js'),
        chunkFilename: utils.assetsPath('js/[id].js')
    },
    resolve: {
        extensions: ['.js', '.jsx', '.json'],
        alias: {
            '@': resolve('src')
        }
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                loader: 'babel-loader',
                options: {
                    presets: ['react-app']
                },
                include: [resolve('src')]
            }
        ]
    }
};
