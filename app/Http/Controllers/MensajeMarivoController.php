<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeMasivo;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\LogEnvioMasivo;
use Illuminate\Support\Facades\Http;

class MensajeMarivoController extends Controller // <- Corregido el nombre de la clase
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

    // Enviar mensaje masivo con integración Venom
    public function enviar($id)
    {
        $mensaje = MensajeMasivo::findOrFail($id);
    $clientes = Cliente::all();

    $logsCreados = [];

    foreach ($clientes as $cliente) {
        $variables = [
            '{{nombre}}' => $cliente->nombre,
            '{{telefono}}' => $cliente->telefono,
        ];

        $mensajeFinal = str_replace(array_keys($variables), array_values($variables), $mensaje->contenido);

        // Crear un nuevo log para cada cliente, sin importar si ya existe
        LogEnvioMasivo::create([
            'mensaje_masivo_id' => $mensaje->id,
            'cliente_id' => $cliente->id,
            'mensaje_final' => $mensajeFinal,
            'estado' => 'pendiente',
        ]);

        // Registrar cliente para el que se creó un nuevo log
        $logsCreados[] = $cliente->id;
    }

    return response()->json([
        'message' => 'Mensajes procesados',
        'logs_creados' => $logsCreados,
    ]);
        // // Llamar a Venom para enviar el mensaje
        // Http::post('http://localhost:3000/send-message', [
        //     'numero' => '57' . $cliente->telefono,
        //     'mensaje' => $mensajeFinal,
        // ]);


    return response()->json(['message' => 'Mensajes generados y enviados']);
    }
}
