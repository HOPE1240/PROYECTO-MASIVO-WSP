<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeMasivoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('mensajes')->group(function () {

    // Crear un mensaje masivo
    Route::post('/crear', [MensajeMasivoController::class, 'crear']);

    // Modificar un mensaje masivo
    Route::put('/{id}/modificar', [MensajeMasivoController::class, 'modificar']);

    // Enviar un mensaje masivo a todos los clientes (registra logs)
    Route::post('/{id}/enviar', [MensajeMasivoController::class, 'enviar']);

});
