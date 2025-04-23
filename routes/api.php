<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeMarivoController;


Route::post('/prueba', function () {
    return response()->json(['message' => 'Ruta de prueba funcionando']);
});

// Crear un mensaje masivo
Route::post('/mensajes/crear', [MensajeMarivoController::class, 'crear']);

// Modificar un mensaje masivo
Route::put('/mensajes/{id}/modificar', [MensajeMarivoController::class, 'modificar']);

// Enviar un mensaje masivo a todos los clientes (registra logs)
Route::post('/mensajes/{id}/enviar', [MensajeMarivoController::class, 'enviar']);
