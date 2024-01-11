const MiniCSSExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require('copy-webpack-plugin');
const path = require('path');

module.exports = {
    mode: 'development',
    entry: '../src',
    watch: true,
    watchOptions: {
        ignored: ['**/node_modules/**', 'front/**']
    },
    output: {
        path: path.resolve(__dirname, "../dist"),
        filename: "js/site.min.js",
        publicPath: "../",
        chunkFilename: 'js/[name].js?t=' + new Date().getTime()
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        plugins: ['@babel/plugin-proposal-class-properties'],
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.(scss|css)$/,
                use: [
                    {
                        loader: MiniCSSExtractPlugin.loader,
                        options: {
                            hmr: process.env.NODE_ENV === 'development',
                        },
                    },
                    // 'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.(svg|jpg|png|jpeg|gif)$/,
                loader: 'file-loader',
                options: {
                    outputPath: 'images',
                    name: '[name].[ext]'
                }
            },
            {
                test: /\.(woff2?|ttf|otf|eot)$/,
                loader: 'file-loader',
                options: {
                    outputPath: 'fonts',
                    name: '[name].[ext]',
                }
            },
            {
                test: /\.script\.js$/,
                use: ['script-loader']
            }
        ]
    },
    plugins: [
        new MiniCSSExtractPlugin({
            filename: "css/site.min.css",
            chunkFilename: "css/[name].css?t=" + new Date().getTime()
        }),
        new CopyPlugin([
            { from: '../dist/css', to: '../../css' },
            { from: '../dist/js', to: '../../js' },
            { from: '../dist/fonts', to: '../../fonts' },
        ]),
    ],
    externals: {
        jquery: 'jQuery'
    }
};