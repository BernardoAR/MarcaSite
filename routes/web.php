<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\LoginController::class, 'index']);

Route::get('/deslogar', [App\Http\Controllers\LoginController::class, 'deslogar']);


// Prefixo para o login
Route::prefix('/login')->group(function () {
    Route::post('/logar', [LoginController::class, 'logar']);
    Route::post('/deslogar', [LoginController::class, 'deslogar']);
});

Route::get('/{any}', [App\Http\Controllers\SpaController::class, 'index'])->where('any', '.*');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
