<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\FilesChamadoController;

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

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::resource('/sites', SiteController::class);

# rotas para chamados
Route::get('/chamados/abertos', [ChamadoController::class, 'abertos']);
Route::get('/chamados/{site}/create', [ChamadoController::class, 'create']);
Route::get('/chamados/{site}/', [ChamadoController::class, 'index']);
Route::post('/chamados/{site}/', [ChamadoController::class, 'store'])->name('chamados.store');
Route::get('/chamados/{site}/{chamado}', [ChamadoController::class, 'show']);

# rotas comentários
Route::post('/comentarios/{chamado}/', [ComentarioController::class, 'store'])->name('comentarios.store');;

# Senha única USP
Route::get('/senhaunica/login', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::post('/sites/{site}/install', [SiteController::class, 'installSite']);
Route::post('/sites/{site}/disable', [SiteController::class, 'disableSite']);
Route::post('/sites/{site}/enable', [SiteController::class, 'enableSite']);
Route::get('/sites/{site}/changeowner', [SiteController::class, 'changeOwner']);
Route::get('/sites/{site}/novoadmin', [SiteController::class, 'novoAdmin']);

Route::get('check', [SiteController::class, 'check']);
Route::get('/emails', [EmailController::class, 'emails']);

# Rotas Avisos
Route::resource('/avisos', AvisoController::class);

Route::resource('/files_chamados', FilesChamadoController::class);
