<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');

    return redirect(route("home"));

});

Route::group(['middleware' => ['auth',"role"]], function () {

    Route::get('/dashboard', 'DashboardController@index');

    Route::get('/dashboard/users', 'UserController@index')->name('user.index');
    Route::post('/dashboard/users/create', 'UserController@store')->name('user.store');
    Route::get('/dashboard/users/{user}', 'UserController@show')->name('user.show');
    Route::patch('/dashboard/users/{user}', 'UserController@update')->name('user.update');
    Route::delete('/dashboard/users/{user}', 'UserController@destroy')->name('user.destroy');

    Route::get('/dashboard/materials', 'MaterialController@index');

    Route::get('/dashboard/courses', 'CourseController@index');

    Route::get('/dashboard/bundles', 'BundleController@index');

});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



