react-skeleton-webpack-plugin
=========

[![npm (scoped with tag)](https://img.shields.io/npm/v/react-skeleton-webpack-plugin.svg)](https://npmjs.com/package/react-skeleton-webpack-plugin)
[![Build Status](https://api.travis-ci.org/lavas-project/react-skeleton-webpack-plugin.svg?branch=master)](https://travis-ci.org/lavas-project/react-skeleton-webpack-plugin)
[![Coverage Status](https://coveralls.io/repos/github/lavas-project/react-skeleton-webpack-plugin/badge.svg?branch=master)](https://coveralls.io/github/lavas-project/react-skeleton-webpack-plugin)
[![NPM downloads](https://img.shields.io/npm/dm/react-skeleton-webpack-plugin.svg)](https://npmjs.com/package/react-skeleton-webpack-plugin)

English|[中文](./README.zh-CN.md)

This is a Webpack plugin based on React which generates Skeleton Screen for SPA and MPA.
A Skeleton Screen includes DOM and Styles inlined in HTML during the building process.

[Vue Version](https://github.com/lavas-project/vue-skeleton-webpack-plugin)

## Getting Started

Install：
```bash
npm install react-skeleton-webpack-plugin
```

Run test cases：
```bash
npm run test
```

Use in Webpack：
```js
// webpack.config.js

import SkeletonWebpackPlugin from 'react-skeleton-webpack-plugin';

plugins: [
    new SkeletonWebpackPlugin({
        webpackConfig: require('./webpack.skeleton.conf')
    })
]
```

A Webpack config for Skeleton is also required:
```js
// webpack.skeleton.conf

module.exports = merge(baseWebpackConfig, {
    target: 'node',
    devtool: false,
    entry: {
        app: resolve('./src/entry-skeleton.js')
    },
    output: Object.assign({}, baseWebpackConfig.output, {
        libraryTarget: 'commonjs2'
    }),
    externals: nodeExternals({
        whitelist: /\.css$/
    }),
    module: {
        rules: utils.styleLoaders({
            sourceMap: false,
            extract: true
        })
    },
    plugins: []
});
```

The entry file `entry-skeleton.js` uses [React SSR](https://reactjs.org/docs/react-dom-server.html) to render Skeleton component：
```js
// entry-skeleton.js

import React from 'react';
import ReactDOM from 'react-dom';
import ReactDOMServer from 'react-dom/server';
import Skeleton from './Skeleton';

let html = ReactDOMServer.renderToStaticMarkup(<Skeleton />);

export default html;
```

## Options for Plugin

This plugin support following options：
- webpackConfig *required*, a Webpack config for Skeleton
- insertAfter *optional*, mounting point to inject Skeleton DOM，default value is `'<div id="app">'`
- router *optional*, used by multi-skeleton in SPA
    - mode, router mode, `history|hash`
    - routes, an array for routes, every route object contains:
        - path, route path
        - skeletonId, the id of Skeleton DOM
- minimize *optional* minimize the JS code inject in HTML, default value is `true`

## Examples

See [examples](https://github.com/lavas-project/react-skeleton-webpack-plugin/examples).
* [Single Skeleton in SPA](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/simple/)
* [MPA](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/multipage/)
* [Multi Skeleton in SPA](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/multi-skeleton/)
