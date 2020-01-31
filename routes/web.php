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

    // agreements
    Route::get('agreementlist', 'AgreementController@agreementlist')->name('agreement-list');
    Route::post('addagreement', 'AgreementController@addagreement')->name('add-agreement');
    Route::delete('delete_agreement/{id}/{type}', 'AgreementController@destroy')->name('delete_agreement');
    Route::get('agreement/search', 'AgreementController@search')->name('agreement.search');

    // Expenses
    Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
        Route::get('/list', 'ExpenseController@expenselist')->name('list');
        Route::post('/addexpense', 'ExpenseController@addexpense')->name('add');

        Route::get('/edit/{id}', 'ExpenseController@edit');
        Route::POST('/update/{id}', 'ExpenseController@update');

        Route::post('/new/approve/{id}', 'ExpenseController@approve');
        Route::post('/new/reject/{id}', 'ExpenseController@reject');

        Route::post('/new/history', 'ExpenseController@searchHistory')->name('history');
        Route::POST('/pending', 'ExpenseController@searchPending')->name('pending');
        Route::POST('/destroy/{id}', 'ExpenseController@destroy');
    });

    // Additional Benefits Spending
    Route::group(['prefix' => 'additional-benefits'], function () {
        

        Route::get('/', 'AdditionlBenifitsSpendingController@index')->name('additional-benefits.index');
        Route::post('/store', 'AdditionlBenifitsSpendingController@store')->name('additional-benefits.store');

        Route::get('/edit/{id}', 'AdditionlBenifitsSpendingController@edit');
        Route::POST('/update/{id}', 'AdditionlBenifitsSpendingController@update');

        Route::post('/approve/{id}', 'AdditionlBenifitsSpendingController@approve');
        Route::post('/reject/{id}', 'AdditionlBenifitsSpendingController@reject');

        Route::post('/paid/{id}', 'AdditionlBenifitsSpendingController@paid');
        Route::post('/non-paid/{id}', 'AdditionlBenifitsSpendingController@nonPaid');

        Route::post('/history', 'AdditionlBenifitsSpendingController@searchHistory')->name('additional-benefits.history');
        Route::POST('/pending', 'AdditionlBenifitsSpendingController@searchPending')->name('additional-benefits.pending');
        Route::POST('/destroy/{id}', 'AdditionlBenifitsSpendingController@destroy');

    });

    // Personal development plan
    Route::group(['prefix' => 'personal-development-plan'], function () {
       
        Route::get('/', 'PersonalDevelopmentPlanController@index')->name('personal-development-plan.index');
        Route::post('/comment/store/{id}', 'PersonalDevelopmentPlanController@commentStore');
        Route::post('/comment/update/{id}', 'PersonalDevelopmentPlanController@commentUpdate');
        
        Route::post('/store', 'PersonalDevelopmentPlanController@store')->name('personal-development-plan.store');

        Route::get('/edit/{id}', 'PersonalDevelopmentPlanController@edit');
        Route::POST('/update/{id}', 'PersonalDevelopmentPlanController@update');

        Route::get('/show/{id}', 'PersonalDevelopmentPlanController@show');

        Route::post('/archive', 'PersonalDevelopmentPlanController@searchArchive')->name('personal-development-plan.archive');
        Route::POST('/destroy/{id}', 'PersonalDevelopmentPlanController@destroy');

    });

    //Company


    Route::group(['prefix' => 'company'], function () {
        Route::get('', 'CompanyController@index')->name('company.index');
        Route::POST('/search', 'CompanyController@searchCompanyPage')->name('company.search');
        Route::get('/create', 'CompanyController@create')->name('company.create');
        Route::post('/store', 'CompanyController@store')->name('company.store');
        Route::get('/edit/{id}', 'CompanyController@edit');
        Route::POST('/update/{id}', 'CompanyController@update');
        Route::POST('/destroy/{id}', 'CompanyController@destroy');
    });

      // Efficiency

    Route::group(['prefix' => 'efficiency'], function () {

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
        Route::post('/ticket_inprogress', 'MaintenanceController@ticket_inprogress')->name('ticket_inprogress');
        Route::post('/ticket_cancel', 'MaintenanceController@ticket_cancel')->name('ticket_cancel');
        Route::get('search', 'MaintenanceController@search')->name('search');
       
    });

    // mileage
    Route::group(['prefix' => 'mileage', 'as' => 'mileage.'], function () {
        Route::get('mileagelist', 'MileageController@mileagelist')->name('mileage-list');
        Route::post('edit', 'MileageController@edit')->name('edit');
        Route::post('update', 'MileageController@update')->name('update');
        Route::post('destroy', 'MileageController@destroy')->name('destroy');
        Route::post('/pending/{id}', 'MileageController@mileagePending');
        Route::post('/approve/{id}', 'MileageController@mileageApprove');
        Route::post('/reject/{id}', 'MileageController@mileageReject');
        Route::post('/search/pending', 'MileageController@searchPendingMileage')->name('pending');
        Route::post('/search/history', 'MileageController@searchHistoryMileage')->name('history');
    });

    // Journal
    Route::group(['prefix' => 'journal', 'as' => 'journal.'], function () {
        Route::get('/', 'JournalController@index')->name('index');
        Route::post('/store', 'JournalController@store')->name('store');
        Route::post('/search', 'JournalController@searchJournal')->name('search-journal');
        Route::get('/edit/{id}', 'JournalController@edit')->name('edit-single-journal');
        Route::POST('/update/{id}', 'JournalController@update');
        Route::POST('/destroy/{id}', 'JournalController@destroy');
    });

    // timeoff route
    Route::group(['prefix' => 'timeoff', 'as' => 'timeoff.'], function () {
        Route::get('/list', 'TimeoffController@timeofflist')->name('list');
    });

    // Paystatement route
    Route::group(['prefix' => 'paystatement', 'as' => 'paystatement.'], function () {
        Route::get('/list', 'PaystatementController@paylist')->name('list');
        Route::POST('/search', 'PaystatementController@searchPaymentPage')->name('search');
        Route::post('/store', 'PaystatementController@store')->name('store');
        Route::POST('/destroy/{id}', 'PaystatementController@destroy');

    });


    Route::get('force-login/{user}', 'UserController@forceLogin')->name('force-login');
    Route::get('users/search', 'UserController@search')->name('users.search');

    // Plan routes go here
    Route::get('plans', 'PlanController@index')->name('plans.index');
    Route::post('plans/store', 'PlanController@store')->name('plans.store');
    Route::put('plans/{plan}', 'PlanController@update')->name('plans.update');

    // Missions routes go here
    Route::get('missions', 'MissionController@index')->name('missions.index');
    Route::post('missions/store', 'MissionController@store')->name('missions.store');
    Route::put('missions/{plan}', 'MissionController@update')->name('missions.update');

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

Route::post('/reset/password/{id}', 'UserController@changeUserPassword');
Route::post('/reset/stuff/password/{id}', 'UserController@changeStuffPassword');

