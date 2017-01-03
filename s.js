Elixir.webpack.mergeConfig({
    babel: {
        presets: ['es2015'],
        plugins: ['transform-runtime'],
    },
    module: {
        loaders: [
          {
              test:/\.js$/,
              loaders:["vue-loader"],
          },
          {
            test: /\.vue$/,
            loader: 'vue',
          },
          {
            test: /\.css$/,
            include: /node_modules/,
            loader: 'style!css'
        }]
    },
    resolve: {
      alias: {vue: './node_modules/vue/dist/vue.js'}
    },
});
