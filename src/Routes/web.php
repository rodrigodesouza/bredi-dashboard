<?php

use Bredi\BrediDashboard\Http\Middleware\ValidaPermissao;

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
// Authentication Routes...
Route::get('/login', 'BrediDashboardController@formLogin')->name('bredidashboard::login'); //->as('bredidashboard::');
Route::post('/login', ['uses' => 'Auth\BrediDashboardLoginController@login', 'as' => 'login']);
Route::get('logout', 'Auth\BrediDashboardLoginController@logout')->name('bredidashboard::logout');
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::prefix(config('bredidashboard.prefix'))->middleware('auth', ValidaPermissao::class)->as('bredidashboard::')->group(function () {
    
    Route::get('template', function () {
        return config('bredidashboard.template');
    });
    // Password Reset Routes...
    // $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    // $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    // $this->post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('/', ['uses' => 'BrediDashboardController@index', 'permissao' => 'dashboard'])->name('dashboard');
    Route::get('usuarios', ['uses' => 'UsuarioController@index', 'permissao' => 'controle.usuario.index'])->name('controle.usuario.index');
    Route::get('grupo-de-usuarios', ['uses' => 'GrupoUsuarioController@index', 'permissao' => 'controle.grupo-usuario.index'])->name('controle.grupo-usuario.index');
    Route::get('permissoes', ['uses' => 'PermissaoController@index', 'permissao' => 'controle.permissao.index'])->name('controle.permissao.index');
});

// Route::get('/restrito', ['uses' => 'BrediDashboardController@index', 'permissao' => 'index'])->middleware('auth', ValidaPermissao::class);