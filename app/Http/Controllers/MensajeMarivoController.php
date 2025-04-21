<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeMasivo;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\LogEnvioMasivo;

class MensajeMarivoController extends Controller
{
    // Crear mensaje masivo
    public function crear(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'variables' => 'nullable|array',
            'ruta_imagen' => 'nullable|string',
        ]);

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

    // Modificar mensaje masivo
    public function modificar(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'variables' => 'nullable|array',
            'ruta_imagen' => 'nullable|string',
        ]);

        $mensaje = MensajeMasivo::findOrFail($id);

        $mensaje->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'variables' => $request->variables,
            'ruta_imagen' => $request->ruta_imagen,
        ]);

        return response()->json(['message' => 'Mensaje masivo modificado con éxito', 'mensaje' => $mensaje]);
    }

    // Enviar mensaje masivo (simulado - falta integración con WhatsApp o servicio real)
    public function enviar($id)
    {
        $mensaje = MensajeMasivo::findOrFail($id);
        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            $mensajeFinal = str_replace('{{nombre}}', $cliente->nombre, $mensaje->contenido);

            LogEnvioMasivo::create([
                'mensaje_masivo_id' => $mensaje->id,
                'cliente_id' => $cliente->id,
                'mensaje_final' => $mensajeFinal,
                'estado' => 'pendiente',
            ]);
        }

        return response()->json(['message' => 'Mensajes generados y encolados para envío']);
    }
}
