<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeMasivo;
use App\Models\Cliente;
use App\Models\LogEnvioMasivo;
use Illuminate\Support\Facades\Http;

class MensajeMarivoController extends Controller
{
    // Enviar mensaje masivo con integración Venom
    public function enviar($id, Request $request)
    {
        // Buscar el mensaje masivo por ID
        $mensaje = MensajeMasivo::findOrFail($id);

        // Verificar si se envía un cliente específico o un array de IDs
        $clienteId = $request->input('cliente_id'); // ID de un cliente específico
        $clienteIds = $request->input('cliente_ids'); // Array de IDs de clientes

        // Obtener los clientes según los parámetros proporcionados
        if ($clienteIds) {
            $clientes = Cliente::whereIn('id', $clienteIds)->get(); // Filtrar por array de IDs
        } elseif ($clienteId) {
            $clientes = Cliente::where('id', $clienteId)->get(); // Filtrar por un cliente específico
        } else {
            $clientes = Cliente::all(); // Obtener todos los clientes si no se especifica
        }

        $logsCreados = [];
        $resultados = [];

        foreach ($clientes as $cliente) {
            // Validar que el cliente tenga un número de teléfono válido
            if (empty($cliente->telefono)) {
                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => null,
                    'status' => 'error',
                    'error' => 'El cliente no tiene un número de teléfono válido.',
                ];
                continue; // Saltar al siguiente cliente
            }

            // Reemplazar variables en el mensaje
            $mensajeFinal = str_replace(
                ['{{nombre}}', '{{telefono}}'],
                [$cliente->nombre, $cliente->telefono],
                $mensaje->contenido
            );

            // Crear un log para el cliente
            $logsCreados[] = LogEnvioMasivo::create([
                'mensaje_masivo_id' => $mensaje->id,
                'cliente_id' => $cliente->id,
                'mensaje_final' => $mensajeFinal,
                'estado' => 'pendiente',
            ])->id;

            // Llamar a Venom para enviar el mensaje
            try {
                $response = Http::post('http://localhost:3000/send-message', [
                    'numero' => '57' . $cliente->telefono,
                    'mensaje' => $mensajeFinal,
                ]);

                // Verificar si la respuesta de Venom fue exitosa
                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => '57' . $cliente->telefono,
                    'status' => $response->successful() ? 'enviado' : 'error',
                    'error' => $response->successful() ? null : $response->body(),
                ];
            } catch (\Exception $e) {
                // Manejar errores en la llamada a Venom
                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => '57' . $cliente->telefono,
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
            }
        }

        // Retornar la respuesta con los resultados
        return response()->json([
            'message' => 'Mensajes procesados',
            'logs_creados' => $logsCreados,
            'resultados' => $resultados,
        ]);
    }
}
