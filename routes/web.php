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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Route::get('/login','LoginController@index')->name('login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('home', 'HomeController@home')->name('home');
    Route::get('edit-profile', 'HomeController@editProfile')->name('edit-profile');
    Route::post('edit_employee', 'HomeController@edit_employee');

    // agreements
    Route::get('agreementlist', 'AgreementController@agreementlist');
    Route::post('addagreement', 'AgreementController@addagreement')->name('add-agreement');
    Route::delete('delete_agreement/{id}/{type}', 'AgreementController@destroy')->name('delete_agreement');
    Route::get('agreement/search', 'AgreementController@search')->name('agreement.search');

    // Expenses
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
        Route::get('/list', 'ExpenseController@expenselist');
        Route::post('/addexpense', 'ExpenseController@addexpense');

        Route::get('/edit/{id}', 'ExpenseController@edit');
        Route::POST('/update/{id}', 'ExpenseController@update');

        Route::post('/new/approve/{id}', 'ExpenseController@approve');
        Route::post('/new/reject/{id}', 'ExpenseController@reject');

        Route::post('/new/history', 'ExpenseController@searchHistory');
        Route::POST('/pending', 'ExpenseController@searchPending');
        Route::POST('/destroy/{id}', 'ExpenseController@destroy');

    });

    Route::group(['prefix' => 'company'], function () {
        Route::get('', 'CompanyController@index')->name('company.index');
        Route::POST('/search', 'CompanyController@searchCompanyPage');
        Route::get('/create', 'CompanyController@create');
        Route::post('/store', 'CompanyController@store');
        Route::get('/edit/{id}', 'CompanyController@edit');
        Route::POST('/update/{id}', 'CompanyController@update');
        Route::POST('/destroy/{id}', 'CompanyController@destroy');
    });

    Route::post('/reset_apssword', 'RegisterController@reset_password')->name('reset_apssword');
    Route::post('/registration', 'RegisterController@store')->name('registration');

    ///// Maintenance
    Route::group(['prefix' => 'maintenance', 'as' => 'maintenance.'], function () {
        Route::get('/list', 'MaintenanceController@Maintenance_list')->name('list');
        Route::post('/add', 'MaintenanceController@addmaintenance')->name('add');
        Route::post('/editview', 'MaintenanceController@edit_maintenanceview')->name('editview');
        Route::post('/edit', 'MaintenanceController@edit')->name('edit');
        Route::post('/delete', 'MaintenanceController@delete')->name('delete');
        Route::post('/ticket_inprogress', 'MaintenanceController@ticket_inprogress')->name('ticket_inprogress');
        Route::post('/ticket_cancel', 'MaintenanceController@ticket_cancel')->name('ticket_cancel');
        Route::get('search', 'MaintenanceController@search')->name('search');
        /* Route::post('/complited_ticket', 'Maintenance_ticket_controller@complited_ticket')->name('complited_ticket');*/
    });

    // mileage
    Route::group(['prefix' => 'mileage', 'as' => 'mileage.'], function () {
        Route::get('mileagelist', 'MileageController@mileagelist')->name('mileage-list');
        Route::post('edit', 'MileageController@edit')->name('edit');
        Route::post('update', 'MileageController@update')->name('update');
        Route::post('destroy', 'MileageController@destroy')->name('destroy');
        Route::post('/approve/{id}', 'MileageController@mileageApprove');
        Route::post('/reject/{id}', 'MileageController@mileageReject');
        Route::post('/search/pending', 'MileageController@searchPendingMileage')->name('search-pending-mileage');
        Route::post('/search/history', 'MileageController@searchHistoryMileage')->name('search-history-mileage');
    });

    ///// timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeofflist')->name('list');
    });

    //// Paystatement route
    Route::group(['prefix' => 'paystatement', 'as' => 'paystatement.'], function () {
        Route::get('/list', 'PaystatementController@paylist');
        Route::post('/add', 'PaystatementController@addpaystatement')->name('add');
        Route::POST('/search', 'PaystatementController@searchPaymentPage');
        Route::post('/store', 'PaystatementController@store');
        Route::POST('/destroy/{id}', 'PaystatementController@destroy');

    });

    Route::get('force-login/{user}', 'UserController@forceLogin')->name('force-login');
    Route::get('users/search', 'UserController@search')->name('users.search');
});

Route::resource('posts', 'PostController');

Route::post('/reset/password/{id}', 'UserController@changeUserPassword');
Route::post('/reset/stuff/password/{id}', 'UserController@changeStuffPassword');

