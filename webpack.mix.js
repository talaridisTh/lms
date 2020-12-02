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
	.js('resources/js/dashboard/topics/topicsMain.js', 'public/js/dashboard/topics')
	.js('resources/js/dashboard/overview/overview.js', 'public/js/dashboard/overview')

	.js('resources/js/dashboard/courses/coursesMain.js', 'public/js/dashboard/courses')
	.js('resources/js/dashboard/courses/courseProfile.js', 'public/js/dashboard/courses')

	.js('resources/js/dashboard/bundles/bundlesMain.js', 'public/js/dashboard/bundles')
	.js('resources/js/dashboard/bundles/bundleProfile.js', 'public/js/dashboard/bundles')

	.js('resources/js/dashboard/materials/materialsMain.js', 'public/js/dashboard/materials')
	.js('resources/js/dashboard/materials/material.js', 'public/js/dashboard/materials')
	.js('resources/js/dashboard/materials/newMaterial.js', 'public/js/dashboard/materials')
	.js('resources/js/dashboard/materials/pdfMaterial.js', 'public/js/dashboard/materials')

	.js('resources/js/dashboard/users/userMain.js', 'public/js/dashboard/users')
	.js('resources/js/dashboard/users/userProfil.js', 'public/js/dashboard/users')

	.js('resources/js/dashboard/fileManager/fileManager.js', 'public/js/dashboard/fileManager')

	.js('resources/js/dashboard/dashboard.js', 'public/js/dashboard')
	.js('resources/js/dashboard/newContent.js', 'public/js/dashboard')

	.js('resources/js/dashboard/mail/email-main.js', 'public/js/dashboard/mail')
	.js('resources/js/dashboard/mail/compose-email.js', 'public/js/dashboard/mail')
	.js('resources/js/dashboard/mail/edit-email.js', 'public/js/dashboard/mail')

	.js('resources/js/dashboard/settings/general-settings.js', 'public/js/dashboard/settings')
	.js('resources/js/dashboard/settings/home-page.js', 'public/js/dashboard/settings')
	.js('resources/js/dashboard/settings/json-editor.js', 'public/js/dashboard/settings')
	.js('resources/js/dashboard/settings/settings-index.js', 'public/js/dashboard/settings')

	.js('resources/js/dashboard/main.js', 'public/js/dashboard/')

    .js('resources/js/index/courses/indexCourses.js', 'public/js/index/courses')
    .js('resources/js/index/materials/indexMaterials.js', 'public/js/index/materials')
    .js('resources/js/index/chat/message.js', 'public/js/index/chat')
    .js('resources/js/index/guest/guest.js', 'public/js/index/guest')
    .js('resources/js/index/favourites/favourites.js', 'public/js/index/favourites')
    .js('resources/js/index/history/history.js', 'public/js/index/history')
    .js('resources/js/index/announcement/announcement.js', 'public/js/index/announcement')
    .js('resources/js/index/discussions/discussions.js', 'public/js/index/discussions')
    .js('resources/js/index/index.js', 'public/js/index')



    .js('resources/js/index/app.js', 'public/js/index')
    .sass('resources/sass/dashboard/customArticleStyle.scss', 'public/css/dashboard')
    .sass('resources/sass/dashboard/app.scss', 'public/css/dashboard')
    .sass('resources/sass/index/app.scss', 'public/css/index/')
    .sass('resources/sass/index/logIn.scss', 'public/css/index/')
    .browserSync("http://127.0.0.1:8000/")
    .sourceMaps()
	.disableSuccessNotifications()
	.version();

