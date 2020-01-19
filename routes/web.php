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

    // Expenses
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
        Route::get('/list', 'ExpenseController@expenselist');
        Route::post('/addexpense', 'ExpenseController@addexpense');
        Route::post('/expense_edit_view', 'ExpenseController@expense_edit_view');
        Route::post('/edit', 'ExpenseController@expenses_edit')->name('edit');
        Route::post('/delete', 'ExpenseController@delete_expense')->name('delete');
        Route::post('/approve', 'ExpenseController@expense_approve')->name('approve');
        Route::post('/reject', 'ExpenseController@expense_reject')->name('reject');
        Route::post('/history', 'ExpenseController@expenses_historical')->name('history');
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
        /* Route::post('/complited_ticket', 'Maintenance_ticket_controller@complited_ticket')->name('complited_ticket');*/

    });

    // mileage
    Route::get('/mileagelist', 'MileageController@mileagelist')->name('mileagelist');
    Route::post('/addmileage', 'MileageController@addmileage')->name('addmileage');
    Route::post('/employeemileage', 'MileageController@employee_mileagelist');
    Route::post('/get_mileagedetails/{id}', 'MileageController@get_mileage');
    Route::post('/updatemileage', 'MileageController@updatemileage');
    Route::post('/deletemileage/{id}', 'MileageController@deletemileage');


    ///// timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeofflist')->name('list');
    });

    //// Paystatement route
    Route::group(['prefix' => 'paystatement', 'as' => 'paystatement.'], function () {
        Route::get('/list', 'PaystatementController@paylist');
        Route::post('/add', 'PaystatementController@addpaystatement')->name('add');

    });

});


Route::resource('posts', 'PostController');

