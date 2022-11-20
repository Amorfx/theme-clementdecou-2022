const path = require("path")
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');


module.exports = {
  entry : {
    main: ['./assets/js/main.js', './assets/sass/main.scss'],
    single: ['./assets/js/single.js', './assets/sass/single.scss'],
    blog: ['./assets/js/blog.js', './assets/sass/blog.scss'],
    home: ['./assets/js/home.js', './assets/sass/home.scss'],
    page: './assets/sass/page.scss',
  },
  output : {
    path: path.resolve(__dirname, "dist"),
    filename: 'js/[name]-v[contenthash].js'
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          // Translates CSS into CommonJS
          "css-loader",
          // Compiles Sass to CSS
          "sass-loader",
        ],
        exclude: /node_modules/,
      },
      {
        test: /\.(ttf|eot|woff|woff2)/,
        type: 'asset/resource',
        generator: {
          filename: 'fonts/[hash][ext][query]',
        },
      },
      {
        test: /\.svg/,
        type: 'asset/resource',
      },
      {
        test: /\.(gif|png|jpe?g)/,
        type: 'asset/resource',
        generator: {
          filename: 'images/[hash][ext][query]',
        },
      },
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
        },
      }
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles/[name]-v[contenthash].css',
      chunkFilename: 'styles/[id]-v[contenthash].css',
    }),
    new CompressionPlugin({
      minRatio: 1,
    }),
    {
      apply: (compiler) => {
        // Same regexp as in nginx config file.
        const fileRegexp = /(.*)(-v[a-z0-9]+)\.(js|css)/;
        compiler.hooks.thisCompilation.tap({ name: 'RemoveHashPlugin' }, (compilation) => {
          compilation.hooks.processAssets.tap({
            name: 'RemoveHashPlugin',
            stage: webpack.Compilation.PROCESS_ASSETS_STAGE_OPTIMIZE_TRANSFER,
          }, (assets) => {
            /* eslint-disable no-param-reassign */
            Object.keys(assets)
              .filter((fileName) => fileRegexp.test(fileName))
              .forEach((fileName) => {
                assets[fileName.replace(fileRegexp, '$1.$3')] = assets[fileName];
                delete assets[fileName];
              });
            return assets;
            /* eslint-enable no-param-reassign */
          });
        });
      },
    },
  ],
  optimization: {
    minimize: true,
    minimizer: [
      // Extract licences in a different file in order to save some bytes.
      new TerserPlugin({
        terserOptions: {
          output: {
            comments: false,
          },
        },
        extractComments: {
          condition: /^\**!|@preserve|@license|@cc_on/i,
          filename: 'licences.js',
          banner: (licenseFile) => `Licenses: dist/${licenseFile}`,
        },
      }),
    ],
  },
  stats: {
    // Avoid noisy output for CSS children.
    children: false,
  },
}
