const Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore.configureLoaderRule('images', (loaderRule) => {
    loaderRule.exclude = /\.svg$/;
});

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('admin', './assets/admin/index.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableStimulusBridge('./assets/controllers.json')
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })
    .enableReactPreset()
    .enablePostCssLoader()
    .addPlugin(new Dotenv())
    .addAliases({
        '@': path.resolve(__dirname, 'assets'),
    })
    .addRule({
        test: /\.svg$/,
        use: [
            {
                loader: '@svgr/webpack',
            },
        ],
    })

;

module.exports = Encore.getWebpackConfig();

