const path = require('path');
const globImporter = require('node-sass-glob-importer');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require("copy-webpack-plugin");

module.exports = {
    entry: {
        index: './src/scripts/index.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: [
                    '/node_modules',
                    '/vendor'
                ],
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            '@babel/preset-env',
                            '@babel/preset-react'
                        ]
                    }
                }
            },
            {
                test: /\.(scss|css)$/,
                use: [ MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            url: false
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            implementation: require('node-sass'),
                            sassOptions: {
                                importer: globImporter()
                            },
                            sourceMap: true
                        }
                    }
                ],
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "./styles/[name].css",
        })
    ],
    output: {
        environment: {
            arrowFunction: true,
            bigIntLiteral: false,
            const: true,
            destructuring: true,
            dynamicImport: false,
            forOf: true,
            module: false,
        },
        filename: './scripts/[name].js',
        iife: true,
        path: path.resolve(__dirname, 'web/bin'),
        publicPath: '/web/bin'
    }
};
