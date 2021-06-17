<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\TipoContatoController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\ChecaLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/cargo-usuario', [App\Http\Controllers\CargoUsuarioController::class, 'index']);
// Middleware para ter acesso apenas quando logado
Route::prefix('/app')->middleware([ChecaLogin::class])->group(function () {
    Route::get('/tipo-contatos', [TipoContatoController::class, 'index']);
    Route::get('/tipo-usuarios', [TipoUsuarioController::class, 'index']);
    Route::prefix('/tipo-contato')->group(function () {
        Route::post('/store', [TipoContatoController::class, 'store']);
        Route::put('/{id}', [TipoContatoController::class, 'update']);
        Route::delete('/{id}', [TipoContatoController::class, 'destroy']);
    });
    Route::post('/curso/store', [CursoController::class, 'store']);
});
Route::prefix('/usuario')->group(function () {
    Route::post('/store', [UsuarioController::class, 'store']);
});

// Prefixo para pegar cada parte de manipulação da api de dados

// Prefixo para pegar cada parte de manipulação da api de dados
