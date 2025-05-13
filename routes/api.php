<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeMarivoController;


Route::post('/prueba', function () {
    return response()->json(['message' => 'Ruta de prueba funcionando']);
});

Route::post('/mensajes/crear', [MensajeMarivoController::class, 'crear']);
Route::post('/mensajes/{id}/enviar', [MensajeMarivoController::class, 'enviar']);
Route::put('/logs/{id}/actualizar', [MensajeMarivoController::class, 'actualizarLog']);
Route::get('/logs', [MensajeMarivoController::class, 'listarLogs']);
Route::get('/logs/{id}', [MensajeMarivoController::class, 'verLog']);
