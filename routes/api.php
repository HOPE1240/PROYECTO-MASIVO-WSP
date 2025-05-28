<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeMarivoController;




Route::post('/mensajes/{id}/enviar', [MensajeMarivoController::class, 'enviar']);

