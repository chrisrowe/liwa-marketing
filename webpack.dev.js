const path = require('path');
const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');

console.log('Development config');

module.exports = merge(common, {
    mode: 'development',
    devtool: 'inline-source-map',
});
