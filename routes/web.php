<?php

Route::get("/","PublicController@createAccount");
Route::post("/user/register-user","PublicController@storeUserAccount")->name("user.register");
Route::get("/redirect-user-to-pending-page","PublicController@redirectToPendingPage")->name("redirect-pending");

Route::get("/user/add-mobile-number","PublicController@addMobileNumber")->name("user.add-mobile-number")
->middleware("auth");
Route::post("/user/add-mobile-number","PublicController@addMobileNumberPost")->name("user.add-mobile-number-post")->middleware("auth");
Route::get("/user/mobile/otp-verification","PublicController@otpVerification")->name("user.otp-verification")->middleware("auth");
Route::post("/user/mobile/otp-verification","PublicController@otpVerificationPost")->name("user.otp-verification-post")->middleware("auth");

Route::get("/user/address/add-address","PublicController@addAddress")->name("user.add-address")->middleware("auth");
Route::post("/user/address/add-address","PublicController@addAddressPost")->name("user.add-address-post")->middleware("auth");

Route::get("/user/questions/add-answers","PublicController@addAnswers")->name("user.add-answers")->middleware("auth");
Route::post("/user/questions/add-answers","PublicController@addAnswersPost")->name("user.add-answers-post")->middleware("auth");

Route::get("/user/references/add-references","PublicController@addReferences")->name("user.add-references")->middleware("auth");
Route::post("/user/references/add-references","PublicController@addReferencesPost")->name("user.add-references-post")->middleware("auth");


Route::get("/user/schadule/interview","PublicController@schaduleInterview")->name("user.schadule-interview")->middleware("auth");
Route::post("/user/schadule/interview","PublicController@schaduleInterviewPost")->name("user.schadule-interview-post")->middleware("auth");


Route::get("/user/schadule/successful","PublicController@schaduleSuccessful")->name("user.schadule-succuessful")->middleware("auth");



// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->get('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');
Route::get("/appointments/settings","Admin\AppointmentsController@settings")->middleware("auth");
Route::post("/appointments/settings","Admin\AppointmentsController@storeSettings")->name("appointments.store")->middleware("auth");
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('clients', 'Admin\ClientsController');
    Route::post('clients_mass_destroy', ['uses' => 'Admin\ClientsController@massDestroy', 'as' => 'clients.mass_destroy']);
	Route::get('get-employees', 'Admin\EmployeesController@GetEmployees');
    Route::resource('employees', 'Admin\EmployeesController');
    Route::post('employees_mass_destroy', ['uses' => 'Admin\EmployeesController@massDestroy', 'as' => 'employees.mass_destroy']);
    Route::resource('working_hours', 'Admin\WorkingHoursController');
    Route::post('working_hours_mass_destroy', ['uses' => 'Admin\WorkingHoursController@massDestroy', 'as' => 'working_hours.mass_destroy']);
    Route::resource('appointments', 'Admin\AppointmentsController');
    Route::post('appointments_mass_destroy', ['uses' => 'Admin\AppointmentsController@massDestroy', 'as' => 'appointments.mass_destroy']);
	Route::resource('services', 'Admin\ServicesController');
	Route::post('services_mass_destroy', ['uses' => 'Admin\ServicesController@massDestroy', 'as' => 'services.mass_destroy']);
	
});
