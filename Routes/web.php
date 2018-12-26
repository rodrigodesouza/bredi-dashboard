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
// \Illuminate\Support\Facades\Auth::routes();

// Authentication Routes...
Route::get('/login', 'BrediDashboardController@formLogin')->name('bredidashboard::login'); //->as('bredidashboard::');
Route::post('/login', ['uses' => 'Auth\BrediDashboardLoginController@login', 'as' => 'login']);
Route::get('logout', 'Auth\BrediDashboardLoginController@logout')->name('bredidashboard::logout');
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::prefix('controle')
    ->middleware('auth')
    ->as('bredidashboard::')
    ->group(
        function () {
            Route::get('template', function () {
                return config('bredidashboard.template');
            });
            // Password Reset Routes...
            // $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            // $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            // $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            // $this->post('password/reset', 'Auth\ResetPasswordController@reset');
            Route::get('/', 'BrediDashboardController@index');
            // dd(config('bredidashboard.name'));
            // Route::get('/controle', ['uses' => 'BrediDashboardController@index']);
        });
