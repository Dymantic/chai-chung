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

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {

    Route::view('/', 'front.home.page');
    Route::view('about', 'front.about.page');
    Route::view('services', 'front.services.index');
    Route::view('contact', 'front.contact.page');

    Route::get('services/{service}', 'ServicesController@show');


});

Route::post('contact', 'ContactMessageController@store');

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
Route::delete('admin/users/{user}', 'Admin\UsersController@delete');

Route::post('admin/managers', 'Admin\ManagersController@store')->middleware('is_manager');
Route::delete('admin/managers/{user}', 'Admin\ManagersController@delete')->middleware('is_manager');

Route::get('admin/reset-password', 'Admin\UserPasswordController@edit');
Route::post('admin/users/{user}/password', 'Admin\UserPasswordController@update');

Route::get('admin/manage-users', 'Admin\ManagerPagesController@users')->middleware('is_manager');

Route::get('admin/users', 'Admin\UsersController@index')->middleware('is_manager');

Route::get('admin/users/{user}', 'Admin\UsersController@show');

Route::post('admin/users/{user}/rate', 'Admin\UserHourlyRateController@update')->middleware('is_manager');

Route::get('admin/me', 'Admin\ProfilesController@show');


Route::post('admin/clients', 'Admin\ClientsController@store')->middleware('is_manager');
Route::post('admin/clients/{client}', 'Admin\ClientsController@update')->middleware('is_manager');
Route::delete('admin/clients/{client}', 'Admin\ClientsController@delete')->middleware('is_manager');

Route::post('/admin/engagement-codes', 'Admin\EngagementCodesController@store')->middleware('is_manager');
Route::post('/admin/engagement-codes/{engagement_code}', 'Admin\EngagementCodesController@update')->middleware('is_manager');
Route::delete('/admin/engagement-codes/{engagement_code}', 'Admin\EngagementCodesController@delete')->middleware('is_manager');

