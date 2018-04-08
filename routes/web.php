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

Route::get('/{any?}', 'SiteController@index')->name('index');

//**********************Auth routes**********************//
Route::get('login', 'Auth\LoginController@showLoginForm')->name('showLogin');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('forgotPassword', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('resetPassword', 'Auth\ResetPasswordController@reset');

//**********************Cron***********************//
Route::get('update', 'API\CurrencyController@update');

//**********************API************************//
Route::group(['prefix' => 'api'], function () {
    Route::get('/checkAuth', 'API\UserController@checkAuth');
    Route::post('/ajaxRegister', 'Auth\RegisterController@ajaxRegister');
    Route::post('/ajaxLogin', 'Auth\LoginController@ajaxLogin');
    Route::post('/ajaxLogout', 'Auth\LoginController@ajaxLogout');

    Route::get('/getQuestions', 'API\QuestionController@getQuestions');
    Route::get('/getHero', 'API\HeroController@getHero');

    Route::get('/getPaymentSystems', 'API\PaymentSystemController@getPaymentSystems');
    Route::get('/getSupportedCurrencies', 'API\CurrencyController@getSupportedCurrencies');
    Route::get('/getSupportedPaymentSystems/{equivalent}', 'API\PaymentSystemController@getSupportedPaymentSystems');

    Route::post('/requestFilter', 'API\FilterController@requestFilter');
    Route::post('/getRequests', 'API\ExchangeRequestController@getRequests');
    Route::get('/getRequest/{id}', 'API\ExchangeRequestController@getRequest');

    Route::get('/getPaymentSystemName/{payment_system}/{currency}', 'API\PaymentSystemController@getPaymentSystemName');
    Route::get('/getSystemWallet/{equiv}/{ps}', 'API\WalletController@getSystemWallet');

    Route::get('/getCurrenciesRate/{from}/{to}/{ps_from?}/{ps_to?}', 'API\CurrencyController@getCurrenciesRate');

    Route::get('/getStatuses', 'API\StatusController@getStatuses');
    Route::get('/getRequestTypes', 'API\RequestTypeController@getRequestTypes');

    Route::get('/getAdminEmail', 'API\UserController@getAdminEmail');
    Route::post('/storeContact', 'API\ContactController@store');

    Route::middleware('auth')->group(function () {
        Route::post('/makeExchangeRequest', 'API\ExchangeRequestController@makeExchangeRequest');
        Route::post('/replyExchangeRequest', 'API\ExchangeRequestController@replyExchangeRequest');
        Route::post('/getUserRequests', 'API\ExchangeRequestController@getUserRequests');

        Route::get('/getUser/{id}', 'API\UserController@getUser');
        Route::post('/editUser', 'API\UserController@editUser');

        Route::get('/getUserWallets', 'API\WalletController@getUserWallets');
        Route::get('/getWallet/{id}', 'API\WalletController@getWallet');
        Route::get('/deleteWallet/{id}', 'API\WalletController@deleteWallet');
        Route::post('/createWallet', 'API\WalletController@createWallet');
        Route::post('/editWallet/{id}', 'API\WalletController@editWallet');
        Route::get('/selectWallets/{currency}/{payment_system}', 'API\WalletController@selectWallets');

        Route::post('/userRequestFilter', 'API\FilterController@userRequestFilter');
    });
});
