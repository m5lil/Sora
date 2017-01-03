const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
          //    .sass('admin.scss')
          .styles(['./bower_components/sweetalert2/dist/sweetalert2.css'])
          .webpack('app.js')
          //    .scripts(['script.js'],'public/js/script.js')
         .scripts([
          //    './bower_components/theia-sticky-sidebar/js/theia-sticky-sidebar.js',
          //    './node_modules/jquery-match-height/jquery.matchHeight.js',
          //    './node_modules/pace-progress/pace.js',
          //    './resources/assets/js/plugins/modernizr-custom.js',
          //    './node_modules/scrollreveal/src/scrollreveal.js',
          //    './node_modules/sidr/dist/jquery.sidr.js',   //add ; in the first line to avoid TypeError: (intermediate value)
             './bower_components/sweetalert2/dist/sweetalert2.js',
          //    './node_modules/page-accelerator/src/page-accelerator.js',
          //    './node_modules/velocity-animate/velocity.js',
          //    './node_modules/velocity-animate/velocity.ui.js'
          //    './bower_components/Swiper/dist/js/swiper.jquery.js',
          //    './bower_components/Swiper/dist/js/swiper.js'
              ]
              , 'public/js/all.js'
         )
          // .imagemin()
          .copy('./resources/assets/fonts', 'public/fonts')
          .browserSync({
              proxy: 'dakakin.dev'
          })
;
});
