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

    .addRule({
        test: /\.svg$/,
        use: [
            {
                loader: '@svgr/webpack',
            },
        ],
    })

    // .addRule({
    //     test: /\.svg$/,
    //     issuer: /\.[jt]sx?$/,
    //     use: ['@svgr/webpack', 'file-loader'],
    // })
;

module.exports = Encore.getWebpackConfig();

