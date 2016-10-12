const elixir = require('laravel-elixir');


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
    .copy('node_modules/bootstrap-sass/assets/fonts','public/fonts')
    .copy('bower_components/textAngular/dist/textAngular.css', 'public/css')
    .scripts([
      '../../../bower_components/angular/angular.min.js',
      '../../../bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
      '../../../bower_components/textAngular/dist/textAngular-rangy.min.js',
      '../../../bower_components/textAngular/dist/textAngular-sanitize.min.js',
      '../../../bower_components/textAngular/dist/textAngular.min.js',
      '../../../bower_components/ng-file-upload/ng-file-upload.min.js',
      '../../../bower_components/angular-bootstrap-multiselect/angular-bootstrap-multiselect.js',
      'app.js',
      'pages/*.js',
    ], 'public/js/trpz.js');
});
