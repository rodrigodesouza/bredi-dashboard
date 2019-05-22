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

Route::prefix((!empty(config('bredidashboard.prefix')) ? config('bredidashboard.prefix') : 'controle'))->middleware('auth', ValidaPermissao::class)->as('bredidashboard::')->group(function () {
    
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
    Route::get('usuario/create', ['uses' => 'UsuarioController@create', 'permissao' => 'controle.usuario.create'])->name('controle.usuario.create');
    Route::get('usuario/edit/{id}', ['uses' => 'UsuarioController@edit', 'permissao' => 'controle.usuario.edit'])->name('controle.usuario.edit');
    Route::post('usuario/store', ['uses' => 'UsuarioController@store', 'permissao' => 'controle.usuario.store'])->name('controle.usuario.store');
    Route::post('usuario/update/{id}', ['uses' => 'UsuarioController@update', 'permissao' => 'controle.usuario.update'])->name('controle.usuario.update');
    Route::get('usuario/delete/{id}', ['uses' => 'UsuarioController@destroy', 'permissao' => 'controle.usuario.destroy'])->name('controle.usuario.destroy');

    Route::get('grupo-de-usuarios', ['uses' => 'GrupoUsuarioController@index', 'permissao' => 'controle.grupo-usuario.index'])->name('controle.grupo-usuario.index');
    Route::get('grupo-de-usuario/create', ['uses' => 'GrupoUsuarioController@create', 'permissao' => 'controle.grupo-usuario.create'])->name('controle.grupo-usuario.create');
    Route::get('grupo-de-usuario/edit/{id}', ['uses' => 'GrupoUsuarioController@edit', 'permissao' => 'controle.grupo-usuario.edit'])->name('controle.grupo-usuario.edit');
    Route::post('grupo-de-usuario/store', ['uses' => 'GrupoUsuarioController@store', 'permissao' => 'controle.grupo-usuario.store'])->name('controle.grupo-usuario.store');
    Route::post('grupo-de-usuario/update/{id}', ['uses' => 'GrupoUsuarioController@update', 'permissao' => 'controle.grupo-usuario.update'])->name('controle.grupo-usuario.update');
    Route::get('grupo-de-usuario/delete/{id}', ['uses' => 'GrupoUsuarioController@destroy', 'permissao' => 'controle.grupo-usuario.destroy'])->name('controle.grupo-usuario.destroy');


    Route::get('permissoes', ['uses' => 'PermissaoController@index', 'permissao' => 'controle.permissao.index'])->name('controle.permissao.index');

    Route::post('upload-editor', ['uses' => 'BrediDashboardController@uploadEditor', 'permissao' => 'dashboard'])->name('controle.summernote.upload');
    Route::post('delete-image-editor', ['uses' => 'BrediDashboardController@deleteImageEditor', 'permissao' => 'dashboard'])->name('controle.summernote.deleteImageEditor');

});

// Route::get('/restrito', ['uses' => 'BrediDashboardController@index', 'permissao' => 'index'])->middleware('auth', ValidaPermissao::class);