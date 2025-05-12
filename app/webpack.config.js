const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const Dotenv = require('dotenv-webpack');
const path = require('path');
const ENTRY = process.env.ENTRY || 'all';

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore.configureLoaderRule('images', (loaderRule) => {
    loaderRule.exclude = /\.svg$/;
});

// if (ENTRY === 'admin' || ENTRY === 'all') {
    Encore.addEntry('admin/app', './assets/admin/index.jsx');
// }
// if (ENTRY === 'shop' || ENTRY === 'all') {
    Encore
      .addEntry('shop/app', './assets/shop/app.js')
      .addEntry('shop/filter', './assets/shop/common/filter.js')
      .addEntry('shop/dropdown', './assets/shop/common/dropdown.js')
      .addEntry('shop/category', './assets/shop/category/index.js')
      .addEntry('shop/product', './assets/shop/product/index.js')

      .addEntry('shop/style', './assets/shop/styles/app.css')
      .addEntry('shop/swiper-style', './assets/shop/styles/swiper.css')
    ;
// }

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
;


Encore.addRule({
    test: /\.svg$/,
    include: path.resolve(__dirname, 'assets/images/icons'),
    issuer: /\.[jt]sx?$/,
    use: [
        {
            loader: '@svgr/webpack',
            options: { icon: true }
        }
    ]
})


Encore.addRule({
    test: /\.svg$/,
    include: path.resolve(__dirname, 'assets/twig-icons'),
    type: 'asset/resource',
    generator: {
        filename: 'images/[name].[contenthash:8][ext][query]',
    },
})

  Encore.addPlugin(new CopyWebpackPlugin({
      patterns: [
          {
              from: 'assets/images/icons/twig-icons', to: 'images'
          }
      ]
  }))


module.exports = Encore.getWebpackConfig();

