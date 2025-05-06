const Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack');
const path = require('path');
const ENTRY = process.env.ENTRY || 'all';

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore.configureLoaderRule('images', (loaderRule) => {
    loaderRule.exclude = /\.svg$/;
});

if (ENTRY === 'admin' || ENTRY === 'all') {
    Encore.addEntry('admin/app', './assets/admin/index.jsx');
}
if (ENTRY === 'shop' || ENTRY === 'all') {

}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
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

