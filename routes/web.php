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

Route::get('/', 'FrontController@index')->name('index');

Route::middleware('auth')->group(function() {
    Route::get('team', 'FrontController@team')->name('team');
    Route::get('challenge', 'FrontController@quest')->name('challenge');
    Route::post('challenge', 'APIController@submitQuest')->name('challenge.submit');
    Route::get('scoreboard', 'FrontController@scoreboard')->name('scoreboard');
    Route::prefix('manage')->group(function() {
        Route::resource('contest', 'ContestController');
    });
});


//Route::group(['middleware' => ['auth']], function () {
    //會員管理
    //權限：user.manage、user.view
//    Route::resource('user', 'UserController', [
//        'except' => [
//            'create',
//            'store',
//        ],
//    ]);
    //角色管理
    //權限：role.manage
//    Route::group(['middleware' => 'permission:role.manage'], function () {
//        Route::resource('role', 'RoleController', [
//            'except' => [
//                'show',
//            ],
//        ]);
//    });
    //會員資料
//    Route::group(['prefix' => 'profile'], function () {
//        //查看會員資料
//        Route::get('/', 'ProfileController@getProfile')->name('profile');
//        //編輯會員資料
//        Route::get('edit', 'ProfileController@getEditProfile')->name('profile.edit');
//        Route::put('update', 'ProfileController@updateProfile')->name('profile.update');
//    });
    // 競賽管理
//});

Route::group(['namespace' => 'Auth'], function () {
    // 登入/登出驗證
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // 註冊
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('register');
    // 忘記密碼（重設）
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
    //修改密碼
//    Route::get('password/change', 'PasswordController@getChangePassword')->name('password.change');
//    Route::put('password/change', 'PasswordController@putChangePassword')->name('password.change');
//    //驗證信箱
//    Route::get('resend', 'RegisterController@resendConfirmMailPage')->name('confirm-mail.resend');
//    Route::post('resend', 'RegisterController@resendConfirmMail')->name('confirm-mail.resend');
//    Route::get('confirm/{confirmCode}', 'RegisterController@emailConfirm')->name('confirm');
});