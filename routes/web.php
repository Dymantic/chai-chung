<?php

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


Route::view('admin/login', 'admin.auth.login')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout');

Route::view('admin/password/forgot', 'passwords/request-new');
Route::post('admin/password/forgot', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');

Route::view('admin', 'admin.dashboard')->middleware('auth');

Route::post('admin/users', 'Admin\UsersController@store')->middleware('is_manager');
Route::post('admin/users/{user}', 'Admin\UsersController@update');

Route::post('admin/managers', 'Admin\ManagersController@store')->middleware('is_manager');
Route::delete('admin/managers/{user}', 'Admin\ManagersController@delete')->middleware('is_manager');

Route::post('admin/users/{user}/password', 'Admin\UserPasswordController@update');