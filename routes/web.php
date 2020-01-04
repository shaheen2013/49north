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

    // agreements
    Route::get('/agreementlist', 'HomeController@agreement_list')->name('agreementlist');
    Route::post('/addagreement', 'HomeController@add_empagreement')->name('addagreement');

    Route::post('/employee_agreementlist', 'HomeController@employee_agreementlist')->name('employee_agreementlist');

    //Route::get('/', 'PostController@index')->name('home');
    Route::delete('delete_agreement/{id}/{type}', 'HomeController@destroy')->name('delete_agreement');

    // Expenses
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::post('/', 'HomeController@expenses')->name('index');
        Route::post('/list', 'HomeController@expenses_list')->name('list');
        Route::post('/edit_view', 'HomeController@edit_view_expenses')->name('edit_view');
        Route::post('/edit', 'HomeController@expenses_edit')->name('edit');
        Route::post('/delete', 'HomeController@delete_expense')->name('delete');
        Route::post('/approve', 'HomeController@expense_approve')->name('approve');
        Route::post('/reject', 'HomeController@expense_reject')->name('reject');
        Route::post('/histocial', 'HomeController@expenses_historical')->name('historical');
    });

    /*Route::post('/expenses','HomeController@expenses')->name('expenses');
    Route::post('/expenses_list','HomeController@expenses_list')->name('expenses_list');
    */

    Route::post('/reset_apssword', 'RegisterController@reset_password')->name('reset_apssword');
    Route::post('/registration', 'RegisterController@store')->name('registration');

    ///// Maintenance
    Route::post('/maintenance', 'Maintenance_ticket_controller@index')->name('maintenance');
    Route::post('/maintanance_list', 'Maintenance_ticket_controller@maintanance_list')->name('maintanance_list');
    Route::post('/mainance_edit_view_ajax', 'Maintenance_ticket_controller@mainance_edit_view_ajax')->name('mainance_edit_view_ajax');
    Route::post('/maintenance1_edit', 'Maintenance_ticket_controller@maintenance1_edit')->name('maintenance1_edit');
    Route::post('/delete_maintance', 'Maintenance_ticket_controller@delete_maintance')->name('delete_maintance');
    Route::post('/ticket_inprogress', 'Maintenance_ticket_controller@ticket_inprogress')->name('ticket_inprogress');
    Route::post('/ticket_cancel', 'Maintenance_ticket_controller@ticket_cancel')->name('ticket_cancel');
    Route::post('/complited_ticket', 'Maintenance_ticket_controller@complited_ticket')->name('complited_ticket');

    // mileage
    Route::post('/mileagelist', 'MileageController@mileagelist')->name('mileagelist');
    Route::post('/addmileage', 'MileageController@addmileage')->name('addmileage');
    Route::post('/employeemileage', 'MileageController@employee_mileagelist');
    Route::post('/get_mileagedetails/{id}', 'MileageController@get_mileage');
    Route::post('/updatemileage', 'MileageController@updatemileage');
    Route::post('/deletemileage/{id}', 'MileageController@deletemileage');

    // pay statement
    Route::get('admin/addpaystatement', 'Admin\PaystatementController@paystatement');
});


Route::resource('posts', 'PostController');

Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
});


///// Employee Agreement
//Route::post('/employeeagreement', 'EmployeeAgreementController@agreementlist')->name('employeeagreement');

//Route::middleware(['admin'])->group(function () {
	
	
	/// ADMin

//Route::middleware(['admin'])->group(function () {
Route::get('admin/addpaystatement','Admin\PaystatementController@paystatement');
Route::get('admin/registration','Admin\AdminController@index');
Route::get('admin/agreement','Admin\AgreementController@agreementlist');
Route::get('admin/expences_report','Admin\AdminController@expences_report');
Route::get('admin/milegebook','Admin\AdminController@milegebook');
Route::get('admin/tech_maintanance','Admin\AdminController@tech_maintanance');
Route::get('admin/timeoff','Admin\AdminController@timeoff');
Route::get('admin/reportconcern','Admin\AdminController@reportconcern');
Route::post('admin/add_registration','Admin\AdminController@add_registration');

