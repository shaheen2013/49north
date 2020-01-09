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

    Route::get('/index', 'HomeController@index')->name('index');
    Route::get('/home', 'HomeController@home')->name('home');
    Route::post('/edit_employee','HomeController@edit_employee');

    // agreements
    Route::get('agreementlist','AgreementController@agreementlist');
    Route::post('addagreement','AgreementController@addagreement')->name('add-agreement');
    Route::delete('delete_agreement/{id}/{type}', 'AgreementController@destroy')->name('delete_agreement');

    // Expenses
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
        Route::get('/list', 'ExpenseController@expenselist');
        Route::post('/addexpense','ExpenseController@addexpense');
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
    /*Route::post('/maintanance_list', 'Maintenance_ticket_controller@maintanance_list')->name('maintanance_list');
    Route::post('/mainance_edit_view_ajax', 'Maintenance_ticket_controller@mainance_edit_view_ajax')->name('mainance_edit_view_ajax');
    Route::post('/maintenance1_edit', 'Maintenance_ticket_controller@maintenance1_edit')->name('maintenance1_edit');
    Route::post('/delete_maintance', 'Maintenance_ticket_controller@delete_maintance')->name('delete_maintance');
    Route::post('/ticket_inprogress', 'Maintenance_ticket_controller@ticket_inprogress')->name('ticket_inprogress');
    Route::post('/ticket_cancel', 'Maintenance_ticket_controller@ticket_cancel')->name('ticket_cancel');
    Route::post('/complited_ticket', 'Maintenance_ticket_controller@complited_ticket')->name('complited_ticket');*/

    });

    // mileage
    Route::get('/mileagelist', 'MileageController@mileagelist')->name('mileagelist');
    Route::post('/addmileage', 'MileageController@addmileage')->name('addmileage');
    Route::post('/employeemileage', 'MileageController@employee_mileagelist');
    Route::post('/get_mileagedetails/{id}', 'MileageController@get_mileage');
    Route::post('/updatemileage', 'MileageController@updatemileage');
    Route::post('/deletemileage/{id}', 'MileageController@deletemileage');

    // pay statement
    Route::get('admin/addpaystatement', 'Admin\AdminPaystatementController@paystatement');
});


Route::resource('posts', 'PostController');

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    //Route::resource('agreements','AgreementController');
});



Route::get('admin/addpaystatement','Admin\PaystatementController@paystatement');
Route::get('admin/registration','Admin\AdminController@index');
Route::get('admin/agreement','Admin\AdminAgreementController@agreementlist');
Route::get('admin/expences_report','Admin\AdminController@expences_report');
Route::get('admin/milegebook','Admin\AdminController@milegebook');
Route::get('admin/tech_maintanance','Admin\AdminController@tech_maintanance');
Route::get('admin/timeoff','Admin\AdminController@timeoff');
Route::get('admin/reportconcern','Admin\AdminController@reportconcern');
Route::post('admin/add_registration','Admin\AdminController@add_registration');

