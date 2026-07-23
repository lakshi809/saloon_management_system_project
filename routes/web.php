<?php

// ===============================
// PUBLIC ROUTES (NO AUTH)
// ===============================

Route::get('/clientInterface', 'ClientInterfaceController@index')->name('clientInterface');

Route::get('/signin', function () {
    return view('signin');
})->name('login')->middleware('guest');

Route::post('/signin', 'SecurityController@login');

Route::get('/clientSignup', 'SecurityController@signup')->name('clientSignup');
Route::post('/saveClient', 'ClientController@saveClient')->name('saveClient');


// ===============================
// DASHBOARD (PUBLIC or LOGIN REDIRECT TARGET)
// ===============================

Route::get('/', 'DashboardController@dashboardIndex')->name('dashboard');


// ===============================
// AUTH PROTECTED ROUTES
// ===============================

Route::group(['middleware' => 'auth'], function () {

    Route::get('/index', 'DashboardController@dashboardIndex')->name('index');

    Route::get('/logout', 'SecurityController@logout')->name('logout');

    // My Account Routes
    Route::get('/myAccount', 'MyAccountController@index')->name('myAccount');
    Route::post('/getUserDetails', 'MyAccountController@getUserDetails')->name('getUserDetails');
    Route::post('/updateUserDetails', 'MyAccountController@updateUserDetails')->name('updateUserDetails');
    Route::post('/changePassword', 'MyAccountController@changePassword')->name('changePassword');


    //Appointment
    Route::get('/makeAppointment', 'AppointmentController@index')->name('makeAppointment');
    Route::get('/appointmentLog', 'AppointmentLogController@appointmentLog')->name('appointmentLog');
    Route::post('/saveAppointment', 'AppointmentController@saveAppointment')->name('saveAppointment');
    Route::post('/showAmount','AppointmentController@showAmount')->name('showAmount');
    Route::post('/getTimeSlot','AppointmentController@getTimeSlot')->name('getTimeSlot');


    //Appointment Log
    Route::post('/savePayment','AppointmentLogController@savePayment')->name('savePayment');
    Route::post('/cancelAppointment','AppointmentLogController@cancelAppointment')->name('cancelAppointment');


    //Category
    Route::get('/category', 'CategoryController@index')->name('category');
    Route::post('/saveCategory', 'CategoryController@categorySave')->name('saveCategory');
    Route::post('/updateCategory', 'CategoryController@categoryUpdate')->name('updateCategory');
    Route::post('/deleteCategory', 'CategoryController@categoryDelete')->name('deleteCategory');
    Route::post('/activateDeactivate', 'CategoryController@activateDeactivate')->name('activateDeactivate');


    //Client Management
    Route::get('/clientManagement', 'ClientController@index')->name('clientManagement');
    Route::post('/saveClientByAdmin', 'ClientController@saveClientByAdmin')->name('saveClientByAdmin');
    Route::post('/updateClient', 'ClientController@updateClient')->name('updateClient');


    //User Management
    Route::get('/userManagement', 'UserController@index')->name('userManagement');
    Route::post('/saveUser', 'UserController@saveUser')->name('saveUser');
    Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');


      Route::get('/paymentLog', 'PaymentLogController@index')->name('paymentLog');


     // Reports

Route::get('/revenueReport', 'RevenueReportController@revReportIndex')
    ->name('revenueReport');

    Route::get('/clientReport', 'ClientReportController@clientReportIndex')
    ->name('clientReport');


Route::post('/savePayment','AppointmentLogController@savePayment')
    ->name('savePayment');


// Feedback
Route::get('/feedback', 'FeedbackController@index')->name('feedback');
Route::post('/saveFeedback', 'FeedbackController@saveFeedback')->name('saveFeedback');
Route::post('/toggleFeedbackPublish', 'FeedbackController@togglePublish')->name('toggleFeedbackPublish');




});


// ===============================
// TEMP HASH GENERATOR (REMOVE AFTER TEST)
// ===============================

Route::get('/hash', function () {
    return bcrypt('admin123');
});