const path = require('path');

module.exports = {
    mode: 'development',
    entry: path.resolve(__dirname, '..','..', 'resources', 'index.js'),
    output: {
        path: path.resolve(__dirname, '..', '..', 'public', 'js'),
        filename: 'bundle.js'
    },
    module: {
        rules: [{
            exclude: /node_modules/,
            test: /\.m?js$/,
            use: {
                loader: "babel-loader",
                options: {
                    presets: ['@babel/preset-env']
                }
            }
        }]
    }
}