const path = require('path');
const webpack = require('webpack');

/**
 * WordPress Dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
    ...defaultConfig,
    ...{
        entry: [
            './main.js'
        ],
        output: {
            filename: './list.build.js',
            path: path.resolve(__dirname, 'build'),
        },
        module : {
            rules: [
                {
                    test: /\.js?$/,
                    exclude: /(node_modules)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env', '@babel/preset-react']
                        }
                    }
                }
            ]
        },
        plugins: [
            ...defaultConfig.plugins,
            new webpack.ProvidePlugin({
                "React": "react",
            }),
        ],
    }
};