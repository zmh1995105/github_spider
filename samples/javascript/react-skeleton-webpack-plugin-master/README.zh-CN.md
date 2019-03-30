react-skeleton-webpack-plugin
=========

[![npm (scoped with tag)](https://img.shields.io/npm/v/react-skeleton-webpack-plugin.svg)](https://npmjs.com/package/react-skeleton-webpack-plugin)
[![Build Status](https://api.travis-ci.org/lavas-project/react-skeleton-webpack-plugin.svg?branch=master)](https://travis-ci.org/lavas-project/react-skeleton-webpack-plugin)
[![Coverage Status](https://coveralls.io/repos/github/lavas-project/react-skeleton-webpack-plugin/badge.svg?branch=master)](https://coveralls.io/github/lavas-project/react-skeleton-webpack-plugin)
[![NPM downloads](https://img.shields.io/npm/dm/react-skeleton-webpack-plugin.svg)](https://npmjs.com/package/react-skeleton-webpack-plugin)

[English](./README.md)|中文

这是一个基于 React 的 Webpack 插件，为应用生成骨架屏 Skeleton，减少白屏时间，在页面完全渲染之前提升用户感知体验。
使用 React 服务端渲染在构建时渲染 Skeleton 组件，将 DOM 和样式内联到最终输出的 HTML 中。

- 支持 SPA 和 MPA
- 支持 SPA 下按照多条路由路径展示不同 Skeleton

[Vue 版本](https://github.com/lavas-project/vue-skeleton-webpack-plugin)

## 使用方法

安装：
```bash
npm install vue-skeleton-webpack-plugin
```

运行测试用例：
```bash
npm run test
```

在 Webpack 中引入插件：
```js
// webpack.conf.js
import SkeletonWebpackPlugin from 'react-skeleton-webpack-plugin';

plugins: [
    new SkeletonWebpackPlugin({
        webpackConfig: require('./webpack.skeleton.conf')
    })
]
```

其中需要传入供 Skeleton 使用的 Webpack 配置对象 `webpack.skeleton.conf`。一个简单的供 SPA 使用的示例大致如下：
```js
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

其中入口文件 `entry-skeleton.js` 使用 React SSR 渲染 Skeleton 组件：
```js
// entry-skeleton.js

import React from 'react';
import ReactDOM from 'react-dom';
import ReactDOMServer from 'react-dom/server';
import Skeleton from './Skeleton';

let html = ReactDOMServer.renderToStaticMarkup(<Skeleton />);

export default html;
```

## 参数说明

插件包含以下参数：
- webpackConfig *必填*，用于渲染 Skeleton 的 Webpack 配置对象
- insertAfter *选填*，渲染 DOM 结果插入位置，默认值为 `'<div id="app">'`
- router *选填* SPA 下配置各个路由路径对应的 Skeleton
    - mode 路由模式，两个有效值 `history|hash`
    - routes 路由数组，其中每个路由对象包含两个属性：
        - path 路由路径
        - skeletonId Skeleton DOM 的 id
- minimize *选填* SPA 下是否需要压缩注入 HTML 的 JS 代码，默认开启

## 示例

可以参考[示例](https://github.com/lavas-project/react-skeleton-webpack-plugin/examples)。
其中：
* [SPA 下单个 Skeleton](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/simple/)
* [MPA](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/multipage/)
* [SPA 下多个 Skeleton](https://github.com/lavas-project/react-skeleton-webpack-plugin/blob/master/examples/multi-skeleton/)
