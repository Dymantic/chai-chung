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

    Route::get('services/audits', 'ServicePagesController@audits');
    Route::get('services/bookkeeping', 'ServicePagesController@bookkeeping');
    Route::get('services/tax', 'ServicePagesController@tax');
    Route::get('services/business-assistance', 'ServicePagesController@businessAssistance');

    
    Route::get('business-planning', 'BusinessAssistancePagesController@planning');
    Route::get('business-formation', 'BusinessAssistancePagesController@formation');
    Route::get('succession-planning', 'BusinessAssistancePagesController@succession');
    Route::get('foreign-investment-in-taiwan', 'BusinessAssistancePagesController@foreign');

});

Route::post('contact', 'ContactMessageController@store');

Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function() {
    Route::view('login', 'admin.auth.login')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    Route::view('password/forgot', 'passwords/request-new');
    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');

    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'active'], 'namespace' => 'Admin'], function() {

    Route::group(['middleware' => ['is_manager']], function() {
        Route::post('users', 'UsersController@store');

        Route::post('managers', 'ManagersController@store');
        Route::delete('managers/{user}', 'ManagersController@delete');

        Route::get('manage-users', 'ManagerPagesController@users');
        Route::get('manage-clients', 'ManagerPagesController@clients');
        Route::get('manage-engagement-codes', 'ManagerPagesController@engagementCodes');
        Route::get('manage-sessions', 'ManagerPagesController@sessions');

        Route::get('users', 'UsersController@index');

        Route::post('users/{user}/rate', 'UserHourlyRateController@update');


        Route::get('clients/{client}', 'ClientsController@show');
        Route::post('clients', 'ClientsController@store');
        Route::post('clients/{client}', 'ClientsController@update');
        Route::delete('clients/{client}', 'ClientsController@delete');

        Route::get('clients/{client}/sessions', 'ClientSessionsController@index');


        Route::get('engagement-codes/{engagementCode}', 'EngagementCodesController@show');
        Route::post('engagement-codes', 'EngagementCodesController@store');
        Route::post('engagement-codes/{engagement_code}', 'EngagementCodesController@update');
        Route::delete('engagement-codes/{engagement_code}', 'EngagementCodesController@delete');

        Route::get('staff-sessions', 'StaffSessionsController@index');

        Route::post('sessions/{session}/overtime', 'SessionOvertimeController@update');

        Route::get('manage-holidays', 'ManagerPagesController@holidays');

        Route::get('holidays', 'HolidaysController@index');
        Route::get('make-up-days', 'MakeUpDaysController@index');
        Route::post('holidays', 'HolidaysController@store');
        Route::delete('holidays/{holiday}', 'HolidaysController@delete');
        Route::post('make-up-days', 'MakeUpDaysController@store');
        Route::delete('make-up-days/{makeUpDay}', 'MakeUpDaysController@delete');

        Route::get('manage-reports/staff-time', 'ManagerReportsController@staffTime');
        Route::get('manage-reports/client-time', 'ManagerReportsController@clientTime');
        Route::get('manage-reports/engagement-time', 'ManagerReportsController@engagementTime');
        Route::get('manage-reports/staff-cost', 'StaffCostReportPagesController@index');
        Route::get('manage-reports/staff-cost/{report}', 'StaffCostReportPagesController@show');

        Route::get('manage-reports/client-cost', 'ClientCostReportPagesController@index');
        Route::get('manage-reports/client-cost/{report}', 'ClientCostReportPagesController@show');

        Route::get('reports/staff-time', 'StaffTimeReportController@show');
        Route::get('reports/client-time', 'ClientTimeReportController@show');
        Route::get('reports/engagement-time', 'EngagementTimeReportController@show');

        Route::get('exports/reports/staff-time', 'StaffTimeExportController@show');
        Route::get('exports/reports/client-time', 'ClientTimeExportController@show');
        Route::get('exports/reports/engagement-time', 'EngagementTimeExportController@show');
        Route::get('exports/reports/staff-cost/{report}', 'StaffCostExportController@show');
        Route::get('exports/reports/client-cost/{report}', 'ClientCostExportController@show');
        Route::get('exports/reports/annual-leave', 'AnnualLeaveExportController@show');

        Route::post('accepted-leave-requests', 'AcceptedLeaveRequestsController@store');
        Route::post('denied-leave-requests', 'DeniedLeaveRequestsController@store');

        Route::get('staff-leave-requests', 'StaffLeaveRequestsController@index');
        Route::get('upcoming-leave', 'UpcomingLeaveController@index');
        Route::get('past-leave-requests', 'PastLeaveRequestsController@index');
        Route::get('past-leave-requests-page', 'PastLeaveRequestsPageController@show');
    });

    Route::redirect('/', 'admin/dashboard');

    Route::post('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@delete');

    Route::get('reset-password', 'UserPasswordController@edit');
    Route::post('users/{user}/password', 'UserPasswordController@update');

    Route::get('users/{user}', 'UsersController@show');

    Route::get('me', 'ProfilesController@show');

    Route::get('clients', 'ClientsController@index');
    Route::get('engagement-codes', 'EngagementCodesController@index');

    Route::get('sessions', 'SessionsController@index');
    Route::post('sessions', 'SessionsController@store');
    Route::get('sessions/{session}', 'SessionsController@show');
    Route::post('sessions/{session}', 'SessionsController@update');
    Route::delete('sessions/{session}', 'SessionsController@delete');

    Route::get('service-periods', 'ServicePeriodsController@index');



    Route::get('dashboard', 'DashboardController@show');

    Route::get('manage-staff-leave', 'ManagerPagesController@leave');

    Route::post('leave-requests', 'UserLeaveRequestsController@store');

    Route::post('leave-requests/{leaveRequest}', 'UserLeaveRequestsController@update');

    Route::post('covered-leave-requests', 'CoveredLeaveRequestsController@store');
    Route::post('cover-rejected-leave-requests', 'CoverRejectedLeaveRequestsController@store');

    Route::post('cancelled-leave-requests', 'CancelledLeaveRequestsController@store');

    Route::get('leave', 'StaffLeaveController@index');
    Route::get('leave-requests', 'UserLeaveRequestsController@index');

    Route::get('covering-requests', 'CoveringRequestsController@index');
    Route::get('user-covering-requests', 'UserCoveringRequestsController@index');
    Route::get('user-agreed-to-cover', 'UserAgreedToCoverController@index');
});
