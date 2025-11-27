const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');

console.log('Production config');

module.exports = merge(common, {
    mode: 'production'
});
