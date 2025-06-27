<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AvisoController;

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


# Senha única USP
Route::get('/login', [LoginController::class, 'redirectToProvider'])->name('login');
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


