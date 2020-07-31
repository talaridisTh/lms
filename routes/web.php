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

Route::get('/dashboard', function () {
    return view('admin/overview/overviewMain');
})->middleware(['auth', 'role']);

Route::get('/dashboard/users', function () {
    return view('admin/users/usersMain');
})->middleware(['auth', 'role']);

Route::get('/dashboard/materials', function () {
    return view('admin/materials/materialsMain');
})->middleware(['auth', 'role']);

Route::get('/dashboard/courses', function () {
    return view('admin/courses/coursesMain');
})->middleware(['auth', 'role']);

Route::get('/dashboard/bundles', function () {
    return view('admin/bundles/bundlesMain');
})->middleware(['auth', 'role']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
