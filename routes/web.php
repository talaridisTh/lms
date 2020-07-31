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

Route::get('/dashboard', 'DashboardController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/users', 'UserController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/materials', 'MaterialController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/courses', 'CourseController@index')->middleware(['auth', 'role']);

Route::get('/dashboard/bundles', 'BundleController@index')->middleware(['auth', 'role']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
