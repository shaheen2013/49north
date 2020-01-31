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
    Route::post('edit_employee', 'HomeController@edit_employee')->name('edit_employee');

    // Agreements
    Route::get('agreementlist', 'AgreementController@agreementlist')->name('agreement-list');
    Route::post('addagreement', 'AgreementController@addagreement')->name('add-agreement');
    Route::delete('delete_agreement/{id}/{type}', 'AgreementController@destroy')->name('delete_agreement')->middleware('isAdmin');
    Route::get('agreement/search', 'AgreementController@search')->name('agreement.search');

    // Expenses
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
        Route::get('/list', 'ExpenseController@expenselist')->name('list');
        Route::post('/addexpense', 'ExpenseController@addexpense')->name('add');

        Route::get('/edit/{id}', 'ExpenseController@edit')->name('edit');
        Route::POST('/update/{id}', 'ExpenseController@update')->name('update');

        Route::post('/new/approve/{id}', 'ExpenseController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/new/reject/{id}', 'ExpenseController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/new/history', 'ExpenseController@searchHistory')->name('history');
        Route::POST('/pending', 'ExpenseController@searchPending')->name('pending');
        Route::POST('/destroy/{id}', 'ExpenseController@destroy')->name('destroy');
    });

    // Additional Benefits Spending
    Route::group(['prefix' => 'additional-benefits'], function () {
        Route::get('/', 'AdditionlBenifitsSpendingController@index')->name('additional-benefits.index');
        Route::post('/store', 'AdditionlBenifitsSpendingController@store')->name('additional-benefits.store');

        Route::get('/edit/{id}', 'AdditionlBenifitsSpendingController@edit')->name('edit');
        Route::POST('/update/{id}', 'AdditionlBenifitsSpendingController@update')->name('update');

        Route::post('/approve/{id}', 'AdditionlBenifitsSpendingController@approve')->name('approve')->middleware('isAdmin');
        Route::post('/reject/{id}', 'AdditionlBenifitsSpendingController@reject')->name('reject')->middleware('isAdmin');

        Route::post('/paid/{id}', 'AdditionlBenifitsSpendingController@paid')->name('paid');
        Route::post('/non-paid/{id}', 'AdditionlBenifitsSpendingController@nonPaid')->name('non-paid');

        Route::post('/history', 'AdditionlBenifitsSpendingController@searchHistory')->name('additional-benefits.history');
        Route::POST('/pending', 'AdditionlBenifitsSpendingController@searchPending')->name('additional-benefits.pending');
        Route::POST('/destroy/{id}', 'AdditionlBenifitsSpendingController@destroy')->name('destroy');
    });

    // Personal development plan
    Route::group(['prefix' => 'personal-development-plan'], function () {
        Route::get('/', 'PersonalDevelopmentPlanController@index')->name('personal-development-plan.index');
        Route::post('/comment/store/{id}', 'PersonalDevelopmentPlanController@commentStore')->name('comment.store');
        Route::post('/comment/update/{id}', 'PersonalDevelopmentPlanController@commentUpdate')->name('comment.update');

        Route::post('/store', 'PersonalDevelopmentPlanController@store')->name('personal-development-plan.store');

        Route::get('/edit/{id}', 'PersonalDevelopmentPlanController@edit')->name('edit');
        Route::POST('/update/{id}', 'PersonalDevelopmentPlanController@update')->name('update');

        Route::get('/show/{id}', 'PersonalDevelopmentPlanController@show')->name('show');

        Route::post('/archive', 'PersonalDevelopmentPlanController@searchArchive')->name('personal-development-plan.archive');
        Route::POST('/destroy/{id}', 'PersonalDevelopmentPlanController@destroy')->name('destroy');
    });

    // Company
    Route::group(['prefix' => 'company', 'middleware' => 'isAdmin'], function () {
        Route::get('', 'CompanyController@index')->name('company.index');
        Route::POST('/search', 'CompanyController@searchCompanyPage')->name('company.search');
        Route::get('/create', 'CompanyController@create')->name('company.create');
        Route::post('/store', 'CompanyController@store')->name('company.store');
        Route::get('/edit/{id}', 'CompanyController@edit')->name('edit');
        Route::POST('/update/{id}', 'CompanyController@update')->name('update');
        Route::POST('/destroy/{id}', 'CompanyController@destroy')->name('destroy');
    });

    // Efficiency
    Route::group(['prefix' => 'efficiency', 'middleware' => 'isAdmin'], function () {
        Route::get('', 'EfficiencyController@index')->name('efficiency.index');
    });

    Route::post('/reset_apssword', 'RegisterController@reset_password')->name('reset_apssword');
    Route::post('/registration', 'RegisterController@store')->name('registration');

    // Maintenance
    Route::group(['prefix' => 'maintenance', 'as' => 'maintenance.'], function () {
        Route::get('/list', 'MaintenanceController@Maintenance_list')->name('list');
        Route::post('/add', 'MaintenanceController@addmaintenance')->name('add');
        Route::post('/editview', 'MaintenanceController@edit_maintenanceview')->name('editview');
        Route::post('/edit', 'MaintenanceController@edit')->name('edit');
        Route::post('/delete', 'MaintenanceController@delete')->name('delete');
        Route::post('/ticket_inprogress', 'MaintenanceController@ticket_inprogress')->name('ticket_inprogress')->middleware('isAdmin');
        Route::post('/ticket_cancel', 'MaintenanceController@ticket_cancel')->name('ticket_cancel')->middleware('isAdmin');
        Route::get('search', 'MaintenanceController@search')->name('search');
        /* Route::post('/complited_ticket', 'Maintenance_ticket_controller@complited_ticket')->name('complited_ticket');*/
    });

    // Mileage
    Route::group(['prefix' => 'mileage', 'as' => 'mileage.'], function () {
        Route::get('mileagelist', 'MileageController@mileagelist')->name('mileage-list');
        Route::post('edit', 'MileageController@edit')->name('edit');
        Route::post('update', 'MileageController@update')->name('update');
        Route::post('destroy', 'MileageController@destroy')->name('destroy');
        Route::post('/pending/{id}', 'MileageController@mileagePending')->name('pending')->middleware('isAdmin');
        Route::post('/approve/{id}', 'MileageController@mileageApprove')->name('pending')->middleware('isAdmin');
        Route::post('/reject/{id}', 'MileageController@mileageReject')->name('reject')->middleware('isAdmin');
        Route::post('/search/pending', 'MileageController@searchPendingMileage')->name('pending');
        Route::post('/search/history', 'MileageController@searchHistoryMileage')->name('history');
    });

    // Journal
    Route::group(['prefix' => 'journal', 'as' => 'journal.'], function () {
        Route::get('/', 'JournalController@index')->name('index');
        Route::post('/store', 'JournalController@store')->name('store');
        Route::post('/search', 'JournalController@searchJournal')->name('search-journal');
        Route::get('/edit/{id}', 'JournalController@edit')->name('edit-single-journal');
        Route::POST('/update/{id}', 'JournalController@update')->name('update');
        Route::POST('/destroy/{id}', 'JournalController@destroy')->name('destroy');
    });

    // Timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeofflist')->name('list');
    });

    // Paystatement route
    Route::group(['prefix' => 'paystatement', 'as' => 'paystatement.'], function () {
        Route::get('/list', 'PaystatementController@paylist')->name('list');
        Route::POST('/search', 'PaystatementController@searchPaymentPage')->name('search');
        Route::post('/store', 'PaystatementController@store')->name('store')->middleware('isAdmin');
        Route::POST('/destroy/{id}', 'PaystatementController@destroy')->name('destroy')->middleware('isAdmin');
    });

    Route::get('force-login/{user}', 'UserController@forceLogin')->name('force-login');
    Route::get('users/search', 'UserController@search')->name('users.search')->middleware('isAdmin');

    // Plan routes go here
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::post('plans/store', 'PlanController@store')->name('plans.store')->middleware('isAdmin');
    Route::put('plans/{plan}', 'PlanController@update')->name('plans.update')->middleware('isAdmin');

    // Missions routes go here
    Route::get('missions', 'MissionController@index')->name('missions.index');
    Route::post('missions/store', 'MissionController@store')->name('missions.store')->middleware('isAdmin');
    Route::put('missions/{plan}', 'MissionController@update')->name('missions.update')->middleware('isAdmin');

    // Messages routes go here
    Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
        Route::get('/', 'MessageController@index')->name('index');
        Route::post('/store', 'MessageController@store')->name('store');
        Route::get('show/{message}', 'MessageController@show')->name('show');
        Route::get('/{message}/edit', 'MessageController@edit')->name('edit');
        Route::put('/{message}', 'MessageController@update')->name('update');
        Route::delete('/{message}', 'MessageController@destroy')->name('destroy');
        Route::get('/search', 'MessageController@search')->name('search');
        Route::put('/status/{message}', 'MessageController@statusUpdate')->name('status.update')->middleware('isAdmin');
    });
});

Route::resource('posts', 'PostController');

Route::post('/reset/password/{id}', 'UserController@changeUserPassword')->name('reset.password');
Route::post('/reset/stuff/password/{id}', 'UserController@changeStuffPassword')->name('reset.stuff.password');

