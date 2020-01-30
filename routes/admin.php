<?php

use Illuminate\Support\Facades\Route;

/**
 * @todo Update these controllers to match the rest (location and naming convention)
 */
Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('users', 'UserController');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('pay-statements', 'AdminPaystatementController@paystatement')->name('pay-statements');

    Route::get('agreement', 'AdminAgreementController@agreementlist')->name('agreement-list');

    Route::get('registration', 'AdminController@index')->name('registration');
    Route::get('expences_report', 'AdminController@expences_report')->name('expense-report');
    Route::get('milegebook', 'AdminController@milegebook')->name('mileage-book');
    Route::get('tech_maintanance', 'AdminController@tech_maintanance')->name('tech-maintenance');
    Route::get('timeoff', 'AdminController@timeoff')->name('timeoff');
    Route::get('reportconcern', 'AdminController@reportconcern')->name('report-concern');
    Route::post('add_registration', 'AdminController@add_registration')->name('add-registration');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth', 'isAdmin']], function () {
    // permissions
    Route::resource('permissions', 'AdminPermissionsController');
    Route::resource('roles', 'AdminRolesController');
});
