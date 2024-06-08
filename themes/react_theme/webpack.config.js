const path = require('path');
const ReactRefreshWebpackPlugin = require('@pmmmwh/react-refresh-webpack-plugin');
const isDevMode = process.env.NODE_ENV !== 'production';

const PROXY = 'https://react-in-drupal.lndo.site/';
const PUBLIC_PATH = '/themes/react_theme/js/drupal-spa-with-react/dist_dev/';

const config = {
    entry: {
        main: [
            "./js/drupal-spa-with-react/src/index.js"
        ]
    },
    devtool: (isDevMode) ? 'source-map' : false,
    mode: (isDevMode) ? 'development' : 'production',
    output: {
        path: isDevMode ? path.resolve(__dirname, "js/dist_dev") : path.resolve(__dirname, "js/dist"),
        filename: '[name].min.js',
        publicPath: PUBLIC_PATH
    },
    resolve: {
        extensions: ['.js', '.jsx'],
    },
    module: {
        rules: [
            {
                test: /\.js?$/,
                exclude: /node_modules/,
                include: path.join(__dirname, 'js/drupal-spa-with-react/src'),
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'],
                        cacheDirectory: true,
                        plugins: [
                            isDevMode && require.resolve('react-refresh/babel')
                        ].filter(Boolean),
                    }
                },
            },
            {
                test: /\.scss$/, // target .scss files
                    use: [
                    'style-loader', // injects CSS into the DOM
                    'css-loader',   // interprets `@import` and `url()` like `import/require()` and will resolve them
                    'sass-loader'   // loads a Sass/SCSS file and compiles it to CSS
                ]
            }
        ],
    },
    plugins: [
        isDevMode && new ReactRefreshWebpackPlugin(),
    ].filter(Boolean),
    devServer: {
        port: 8181,
        hot: true,
        headers: { 'Access-Control-Allow-Origin': '*' },
        devMiddleware: {
            writeToDisk: true,
        },
        // Settings for http-proxy-middleware.
        proxy: [
            {
                index: '',
                context: ['/'],
                target: PROXY,
                publicPath: PUBLIC_PATH,
                secure: false,
                // These settings allow Drupal authentication to work, so you can sign
                // in to your Drupal site via the proxy. They require some corresponding
                // configuration in Drupal's settings.php.
                changeOrigin: true,
                xfwd: true
            }
        ]
    },
};

module.exports = config;