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

Route::view('admin/login', 'admin.auth.login')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::post('admin/logout', 'Auth\LoginController@logout');

Route::view('admin/password/forgot', 'passwords/request-new');
Route::post('admin/password/forgot', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');

Route::post('contact', 'ContactMessageController@store');

Route::group(['middleware' => 'auth'], function() {

    Route::redirect('admin', 'admin/dashboard');

    Route::post('admin/users', 'Admin\UsersController@store')->middleware('is_manager');
    Route::post('admin/users/{user}', 'Admin\UsersController@update');
    Route::delete('admin/users/{user}', 'Admin\UsersController@delete');

    Route::post('admin/managers', 'Admin\ManagersController@store')->middleware('is_manager');
    Route::delete('admin/managers/{user}', 'Admin\ManagersController@delete')->middleware('is_manager');

    Route::get('admin/reset-password', 'Admin\UserPasswordController@edit');
    Route::post('admin/users/{user}/password', 'Admin\UserPasswordController@update');

    Route::get('admin/manage-users', 'Admin\ManagerPagesController@users')->middleware('is_manager');
    Route::get('admin/manage-clients', 'Admin\ManagerPagesController@clients')->middleware('is_manager');
    Route::get('admin/manage-engagement-codes', 'Admin\ManagerPagesController@engagementCodes')->middleware('is_manager');
    Route::get('admin/manage-sessions', 'Admin\ManagerPagesController@sessions')->middleware('is_manager');

    Route::get('admin/users', 'Admin\UsersController@index')->middleware('is_manager');

    Route::get('admin/users/{user}', 'Admin\UsersController@show');

    Route::post('admin/users/{user}/rate', 'Admin\UserHourlyRateController@update')->middleware('is_manager');

    Route::get('admin/me', 'Admin\ProfilesController@show');

    Route::get('admin/clients', 'Admin\ClientsController@index')->middleware('is_manager');
    Route::get('admin/clients/{client}', 'Admin\ClientsController@show')->middleware('is_manager');
    Route::post('admin/clients', 'Admin\ClientsController@store')->middleware('is_manager');
    Route::post('admin/clients/{client}', 'Admin\ClientsController@update')->middleware('is_manager');
    Route::delete('admin/clients/{client}', 'Admin\ClientsController@delete')->middleware('is_manager');

    Route::get('/admin/engagement-codes', 'Admin\EngagementCodesController@index');
    Route::get('/admin/engagement-codes/{engagementCode}', 'Admin\EngagementCodesController@show')->middleware('is_manager');
    Route::post('/admin/engagement-codes', 'Admin\EngagementCodesController@store')->middleware('is_manager');
    Route::post('/admin/engagement-codes/{engagement_code}', 'Admin\EngagementCodesController@update')->middleware('is_manager');
    Route::delete('/admin/engagement-codes/{engagement_code}', 'Admin\EngagementCodesController@delete')->middleware('is_manager');


    Route::get('admin/staff-sessions', 'Admin\StaffSessionsController@index')->middleware('is_manager');

    Route::get('admin/sessions', 'Admin\SessionsController@index');
    Route::post('admin/sessions', 'Admin\SessionsController@store');

    Route::delete('admin/sessions/{session}', 'Admin\SessionsController@delete');

    Route::post('admin/sessions/{session}/overtime', 'Admin\SessionOvertimeController@update')->middleware('is_manager');

    Route::get('admin/dashboard', 'Admin\DashboardController@show');

    Route::get('admin/manage-holidays', 'Admin\ManagerPagesController@holidays')->middleware('is_manager');

    Route::get('admin/manage-staff-leave', 'Admin\ManagerPagesController@leave');

    Route::get('admin/holidays', 'Admin\HolidaysController@index')->middleware('is_manager');
    Route::get('admin/make-up-days', 'Admin\MakeUpDaysController@index')->middleware('is_manager');
    Route::post('admin/holidays', 'Admin\HolidaysController@store')->middleware('is_manager');
    Route::delete('admin/holidays/{holiday}', 'Admin\HolidaysController@delete')->middleware('is_manager');
    Route::post('admin/make-up-days', 'Admin\MakeUpDaysController@store')->middleware('is_manager');
    Route::delete('admin/make-up-days/{makeUpDay}', 'Admin\MakeUpDaysController@delete')->middleware('is_manager');

    Route::get('admin/manage-reports/staff-time', 'Admin\ManagerReportsController@staffTime')->middleware('is_manager');
    Route::get('admin/manage-reports/client-time', 'Admin\ManagerReportsController@clientTime')->middleware('is_manager');
    Route::get('admin/manage-reports/engagement-time', 'Admin\ManagerReportsController@engagementTime')->middleware('is_manager');

    Route::get('admin/reports/staff-time', 'Admin\StaffTimeReportController@show')->middleware('is_manager');
    Route::get('admin/reports/client-time', 'Admin\ClientTimeReportController@show')->middleware('is_manager');
    Route::get('admin/reports/engagement-time', 'Admin\EngagementTimeReportController@show')->middleware('is_manager');

    Route::get('admin/exports/reports/staff-time', 'Admin\StaffTimeExportController@show')->middleware('is_manager');
    Route::get('admin/exports/reports/client-time', 'Admin\ClientTimeExportController@show')->middleware('is_manager');
    Route::get('admin/exports/reports/engagement-time', 'Admin\EngagementTimeExportController@show')->middleware('is_manager');


    Route::post('admin/leave-requests', 'Admin\UserLeaveRequestsController@store');

    Route::post('admin/leave-requests/{leaveRequest}', 'Admin\UserLeaveRequestsController@update');

    Route::post('admin/covered-leave-requests', 'Admin\CoveredLeaveRequestsController@store');
    Route::post('admin/cover-rejected-leave-requests', 'Admin\CoverRejectedLeaveRequestsController@store');
    Route::post('admin/accepted-leave-requests', 'Admin\AcceptedLeaveRequestsController@store')->middleware('is_manager');
    Route::post('admin/denied-leave-requests', 'Admin\DeniedLeaveRequestsController@store')->middleware('is_manager');
    Route::post('admin/cancelled-leave-requests', 'Admin\CancelledLeaveRequestsController@store');

    Route::get('admin/leave', 'Admin\StaffLeaveController@index');
    Route::get('admin/leave-requests', 'Admin\UserLeaveRequestsController@index');

    Route::get('admin/covering-requests', 'Admin\CoveringRequestsController@index');

    Route::get('admin/user-covering-requests', 'Admin\UserCoveringRequestsController@index');

    Route::get('admin/staff-leave-requests', 'Admin\StaffLeaveRequestsController@index')->middleware('is_manager');
});
