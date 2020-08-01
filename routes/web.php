<?php

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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');

});

Route::get('/dashboard', 'DashboardController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/users', 'UserController@index')->middleware(['auth', 'role'])->name('user.index');
Route::post('/dashboard/users/create', 'UserController@store')->middleware(['auth', 'role'])->name('user.store');;
Route::get('/dashboard/users/{user}', 'UserController@show')->middleware(['auth', 'role'])->name('user.show');;
Route::patch('/dashboard/users/{user}', 'UserController@update')->middleware(['auth', 'role'])->name('user.update');;
Route::delete('/dashboard/users/{user}', 'UserController@destroy')->middleware(['auth', 'role'])->name('user.destroy');;

Route::get('/dashboard/materials', 'MaterialController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/courses', 'CourseController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/bundles', 'BundleController@index')->middleware(['auth', 'role']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


