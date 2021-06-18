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

Route::get('/', function () {
    return view('spa');
});
Route::get('/deslogar', [App\Http\Controllers\LoginController::class, 'deslogar']);

Route::prefix('/app')->middleware([App\Http\Middleware\ChecaLogin::class])->group(function () {
    Route::get('/tipo-contatos', [TipoContatoController::class, 'index']);
    Route::get('/tipo-usuarios', [TipoUsuarioController::class, 'index']);
    Route::prefix('/tipo-contato')->group(function () {
        Route::post('/store', [TipoContatoController::class, 'store']);
        Route::put('/{id}', [TipoContatoController::class, 'update']);
        Route::delete('/{id}', [TipoContatoController::class, 'destroy']);
    });
    Route::prefix('/curso')->group(function () {
        Route::get('/get', [App\Http\Controllers\CursoController::class, 'index']);
        Route::post('/store', [App\Http\Controllers\CursoController::class, 'store']);
    });
});
// Prefixo para o login
Route::prefix('/login')->group(function () {
    Route::post('/logar', [LoginController::class, 'logar']);
});

Route::get('/{any}', [App\Http\Controllers\LoginController::class, 'index'])->where('any', '.*');
