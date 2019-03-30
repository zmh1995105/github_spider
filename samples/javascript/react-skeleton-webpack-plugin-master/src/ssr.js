/**
 * @file ssr
 * @desc Use React ssr to render skeleton components. The result contains html and css.
 * @author panyuqi <panyuqi@baidu.com>
 */

import {join, basename, extname} from 'path';
import webpack from 'webpack';
import ExtractTextPlugin from 'extract-text-webpack-plugin';
import ReactDOMServer from 'react-dom/server';
import MFS from 'memory-fs';
import requireFromString from 'require-from-string';
import {isObject} from './util';

export default async function(serverWebpackConfig, {quiet = false}) {
    // get entry name from webpack.conf
    let outputPath = join(serverWebpackConfig.output.path, serverWebpackConfig.output.filename);
    let outputBasename = basename(outputPath, extname(outputPath));
    let outputCssBasename = `${outputBasename}.css`;
    let outputCssPath = join(serverWebpackConfig.output.path, outputCssBasename);
    let bundle;
    let skeletonCss;

    if (!quiet) {
        console.log(`Generate skeleton for ${outputBasename}...`);
    }

    // extract css into a single file
    serverWebpackConfig.plugins.push(new ExtractTextPlugin({
        filename: outputCssBasename
    }));

    // webpack start to work
    let serverCompiler = webpack(serverWebpackConfig);
    let mfs = new MFS();
    // output to mfs
    serverCompiler.outputFileSystem = mfs;

    // run webpack compiler
    await new Promise((resolve, reject) => {
        serverCompiler.run((err, stats) => {
            if (err) {
                reject(err);
                return;
            }

            stats = stats.toJson();
            stats.errors.forEach(err => {
                console.error(err);
            });
            stats.warnings.forEach(err => {
                console.warn(err);
            });

            resolve();
        });
    });

    if (mfs.existsSync(outputPath)) {
        bundle = mfs.readFileSync(outputPath, 'utf-8');
    }
    if (mfs.existsSync(outputCssPath)) {
        skeletonCss = mfs.readFileSync(outputCssPath, 'utf-8');
    }

    let skeletonHtml = requireFromString(bundle, serverWebpackConfig.output.filename);

    if (isObject(skeletonHtml)) {
        skeletonHtml = skeletonHtml.default;
    }

    return {skeletonHtml, skeletonCss};
};
