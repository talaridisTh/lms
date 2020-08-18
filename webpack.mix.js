const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/dashboard/courses/coursesMain.js', 'public/js/dashboard/courses')
	.js('resources/js/dashboard/courses/courseProfile.js', 'public/js/dashboard/courses')
	.js('resources/js/dashboard/bundles/bundlesMain.js', 'public/js/dashboard/bundles')
	.js('resources/js/dashboard/bundles/bundleProfile.js', 'public/js/dashboard/bundles')
	.js('resources/js/dashboard/materials/materialsMain.js', 'public/js/dashboard/materials')
	.js('resources/js/dashboard/users/userMain.js', 'public/js/dashboard/users')
	.js('resources/js/dashboard/users/userProfil.js', 'public/js/dashboard/users')
	.js('resources/js/dashboard/main.js', 'public/js/dashboard/')
    .sass('resources/sass/app.scss', 'public/css')
    .browserSync("http://127.0.0.1:8000/")
    .sourceMaps()
    .disableSuccessNotifications()
    /* .version() */;

