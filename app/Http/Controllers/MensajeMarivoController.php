<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\MensajeMasivo;

class MensajeMarivoController extends Controller
{
    public function crear(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'variables' => 'nullable|array',
            'ruta_imagen' => 'nullable|string',
        ]);

        // Crear el mensaje masivo
        $mensaje = MensajeMasivo::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'area_id' => $request->area_id,
            'variables' => $request->variables,
            'ruta_imagen' => $request->ruta_imagen,
            'estado' => 'borrador',
        ]);

        return response()->json(['message' => 'Mensaje masivo creado con éxito', 'mensaje' => $mensaje], 201);
    }
}
