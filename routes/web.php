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

Auth::routes([
    'register' => false,
]);

//Route::get('/login','LoginController@index')->name('login');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('edit-profile', 'HomeController@editProfile')->name('edit-profile');
    Route::post('edit_employee', 'HomeController@editEmployee')->name('edit_employee');

    // Agreements
    Route::get('agreementlist', 'AgreementController@agreementList')->name('agreement-list');
    Route::post('addagreement', 'AgreementController@addAgreement')->name('add-agreement');
    Route::delete('delete_agreement/{id}/{type}', 'AgreementController@destroy')->name('delete_agreement')->middleware('isAdmin');
    Route::get('agreement/search', 'AgreementController@search')->name('agreement.search');

    // Expenses
    Route::resource('expenses', 'ExpenseController');
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.', 'middleware' => 'can:expenses-enabled'], function () {
        /*Route::get('/list', 'ExpenseController@expenseList')->name('expense-list');
        Route::post('/addexpense', 'ExpenseController@addExpense')->name('expense-add');

        Route::get('/edit/{id}', 'ExpenseController@edit')->name('edit');
        Route::POST('/update/{id}', 'ExpenseController@update')->name('update');*/

        Route::post('/new/approve/{id}', 'ExpenseController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/new/reject/{id}', 'ExpenseController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/new/history', 'ExpenseController@searchHistory')->name('history');
        Route::POST('/pending', 'ExpenseController@searchPending')->name('pending');
        /*Route::POST('/destroy/{id}', 'ExpenseController@destroy')->name('destroy');*/
    });

    // Additional Benefits Spending
    Route::group(['prefix' => 'additional-benefits', 'as' => 'additional-benefits.', 'middleware' => 'can:additional-spending-enabled'], function () {

        Route::get('/', 'AdditionlBenifitsSpendingController@index')->name('index');
        Route::post('/store', 'AdditionlBenifitsSpendingController@store')->name('store');

        Route::get('/edit/{id}', 'AdditionlBenifitsSpendingController@edit')->name('edit');
        Route::POST('/update/{id}', 'AdditionlBenifitsSpendingController@update')->name('update');

        Route::post('/approve/{id}', 'AdditionlBenifitsSpendingController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/reject/{id}', 'AdditionlBenifitsSpendingController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/paid/{id}', 'AdditionlBenifitsSpendingController@paid')->name('paid');
        Route::post('/non-paid/{id}', 'AdditionlBenifitsSpendingController@nonPaid')->name('non-paid');

        Route::post('/history', 'AdditionlBenifitsSpendingController@searchHistory')->name('history');
        Route::POST('/pending', 'AdditionlBenifitsSpendingController@searchPending')->name('pending');
        Route::POST('/destroy/{id}', 'AdditionlBenifitsSpendingController@destroy')->name('destroy');
    });

    // Personal development plan
    Route::group(['prefix' => 'personal-development-plan', 'as' => 'personal-development-plan.', 'middleware' => 'can:classroom-enabled'], function () {

        Route::get('/', 'PersonalDevelopmentPlanController@index')->name('index');
        Route::post('/comment/store/{id}', 'PersonalDevelopmentPlanController@commentStore')->name('comment.store');
        Route::post('/comment/update/{id}', 'PersonalDevelopmentPlanController@commentUpdate')->name('comment.update');

        Route::post('/store', 'PersonalDevelopmentPlanController@store')->name('store');

        Route::get('/edit/{id}', 'PersonalDevelopmentPlanController@edit')->name('edit');
        Route::POST('/update/{id}', 'PersonalDevelopmentPlanController@update')->name('update');

        Route::get('/show/{id}', 'PersonalDevelopmentPlanController@show')->name('show');

        Route::post('/archive', 'PersonalDevelopmentPlanController@searchArchive')->name('archive');
        Route::POST('/destroy/{id}', 'PersonalDevelopmentPlanController@destroy')->name('destroy');
    });

    // Company
    Route::group(['prefix' => 'company', 'as' => 'company.', 'middleware' => 'isAdmin'], function () {
        Route::get('', 'CompanyController@index')->name('index');
        Route::POST('/search', 'CompanyController@searchCompanyPage')->name('search');
        Route::get('/create', 'CompanyController@create')->name('create');
        Route::post('/store', 'CompanyController@store')->name('store');
        Route::get('/edit/{id}', 'CompanyController@edit')->name('edit');
        Route::POST('/update/{id}', 'CompanyController@update')->name('update');
        Route::POST('/destroy/{id}', 'CompanyController@destroy')->name('destroy');
    });

    // Efficiency
    Route::group(['prefix' => 'efficiency', 'as' => 'efficiency.', 'middleware' => 'isAdmin'], function () {
        Route::get('', 'EfficiencyController@index')->name('index');
    });

    Route::post('/reset_apssword', 'RegisterController@resetPassword')->name('reset_apssword');
    Route::post('/registration', 'RegisterController@store')->name('registration');

    // Maintenance
    Route::group(['prefix' => 'maintenance', 'as' => 'maintenance.', 'middleware' => 'can:maintenance-enabled'], function () {
        Route::get('/list', 'MaintenanceController@maintenanceList')->name('list');
        Route::post('/add', 'MaintenanceController@addMaintenance')->name('add');
        Route::post('/editview', 'MaintenanceController@editMaintenanceView')->name('editview');
        Route::post('/edit', 'MaintenanceController@edit')->name('edit');
        Route::post('/delete', 'MaintenanceController@delete')->name('delete');
        Route::post('/ticket_inprogress', 'MaintenanceController@ticketInProgress')->name('ticket_inprogress')->middleware('isAdmin');
        Route::post('/ticket_cancel', 'MaintenanceController@ticketCancel')->name('ticket_cancel')->middleware('isAdmin');
        Route::get('search', 'MaintenanceController@search')->name('search');

        Route::post('/comment/store/{id}', 'MaintenanceController@commentStore')->name('comment.store');
        Route::post('/comment/update/{id}', 'MaintenanceController@commentUpdate')->name('comment.update');
        Route::get('/show/{id}', 'MaintenanceController@show')->name('show');

    });

    // Mileage
    Route::group(['prefix' => 'mileage', 'as' => 'mileage.', 'middleware' => 'can:mileage-enabled'], function () {
        Route::get('mileagelist', 'MileageController@mileageList')->name('mileage-list');
        Route::post('edit', 'MileageController@edit')->name('edit');
        Route::post('update', 'MileageController@update')->name('update');
        Route::post('destroy', 'MileageController@destroy')->name('destroy');
        Route::post('/pending/{id}', 'MileageController@mileagePending')->name('pending')->middleware('isAdmin');
        Route::post('/approve/{id}', 'MileageController@mileageApprove')->name('approve')->middleware('isAdmin');
        Route::post('/reject/{id}', 'MileageController@mileageReject')->name('reject')->middleware('isAdmin');
        Route::post('/search/pending', 'MileageController@searchPendingMileage')->name('searchPending');
        Route::post('/search/history', 'MileageController@searchHistoryMileage')->name('searchHistory');
    });

    // Journal
    Route::group(['prefix' => 'journal', 'as' => 'journal.', 'middleware' => 'can:classroom-enabled'], function () {
        Route::get('/', 'JournalController@index')->name('index');
        Route::post('/store', 'JournalController@store')->name('store');
        Route::post('/search', 'JournalController@searchJournal')->name('search-journal');
        Route::get('/edit/{id}', 'JournalController@edit')->name('edit');
        Route::POST('/update/{id}', 'JournalController@update')->name('update');
        Route::POST('/destroy/{id}', 'JournalController@destroy')->name('destroy');
    });

    // Timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeOffList')->name('list');
    });

    // Paystatement route
    Route::group(['prefix' => 'paystatement', 'as' => 'paystatement.', 'middleware' => 'can:pay-statement-enabled'], function () {
        Route::get('/list', 'PaystatementController@payList')->name('list');
        Route::POST('/search', 'PaystatementController@searchPaymentPage')->name('search');
        Route::post('/store', 'PaystatementController@store')->name('store');
        Route::POST('/destroy/{id}', 'PaystatementController@destroy')->name('destroy');
    });

    Route::get('force-login/{user}', 'UserController@forceLogin')->name('force-login');
    Route::get('users/search', 'UserController@search')->name('users.search');

    // Plan routes go here
    Route::group(['prefix' => 'plans', 'as' => 'plans.', 'middleware' => 'can:plan-overview-enabled'], function () {
    Route::get('/', 'PlanController@index')->name('index');
    Route::post('/store', 'PlanController@store')->name('store');
    Route::put('/{plan}', 'PlanController@update')->name('update');
    });

    Route::group(['prefix' => 'missions', 'as' => 'missions.', 'middleware' => 'can:classroom-enabled'], function () {
    // Missions routes go here
    Route::get('/', 'MissionController@index')->name('index');
    Route::post('/store', 'MissionController@store')->name('store');
    Route::put('/{plan}', 'MissionController@update')->name('update');
    });

    // Messages routes go here
    Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
        Route::get('/', 'MessageController@index')->name('index');
        Route::post('/store', 'MessageController@store')->name('store');
        Route::get('show/{message}', 'MessageController@show')->name('show');
        Route::get('/{message}/edit', 'MessageController@edit')->name('edit');
        Route::put('/{message}', 'MessageController@update')->name('update');
        Route::delete('/{message}', 'MessageController@destroy')->name('destroy');
        Route::get('/search', 'MessageController@search')->name('search');
        Route::put('/status/{message}', 'MessageController@statusUpdate')->name('status.update');
    });
});

Route::resource('posts', 'PostController');

Route::post('/reset/password/{id}', 'UserController@changeUserPassword')->name('reset.password');
Route::post('/reset/stuff/password/{id}', 'UserController@changeStuffPassword')->name('reset.stuff.password');
Route::get('/employee/module', 'HomeController@employeeModule')->name('employee.module');
Route::get('/benefits/module', 'HomeController@benefitsModule')->name('benefits.module');
Route::get('/classroom/module', 'HomeController@classroomModule')->name('classroom.module');

