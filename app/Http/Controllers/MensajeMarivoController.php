<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeMasivo;
use App\Models\Cliente;
use App\Models\LogEnvioMasivo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MensajeMarivoController extends Controller
{
    // Crear mensaje masivo
    public function crear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'area_id' => 'required|integer|exists:areas,id',
            'variables' => 'nullable|array',
            'ruta_imagen' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $mensaje = new MensajeMasivo();
        $mensaje->titulo = $request->input('titulo');
        $mensaje->contenido = $request->input('contenido');
        $mensaje->area_id = $request->input('area_id');
        $mensaje->variables = $request->input('variables', []);
        $mensaje->ruta_imagen = $request->input('ruta_imagen');
        $mensaje->save();

        return response()->json([
            'success' => true,
            'message' => 'Mensaje masivo creado correctamente.',
            'mensaje' => $mensaje,
        ], 201);
    }


    public function enviar($id, Request $request)
    {
        set_time_limit(0);
        $mensaje = MensajeMasivo::findOrFail($id);

        // Hora límite
        // $horaLimite = Carbon::createFromTime(12, 57, 0, 'America/Bogota');

        $clienteId = $request->input('cliente_id');
        $clienteIds = $request->input('cliente_ids');

        // Solo procesa si se envía cliente_id o cliente_ids
        if ($clienteIds) {
            $clientes = Cliente::whereIn('id', $clienteIds)->get();
        } elseif ($clienteId) {
            $clientes = Cliente::where('id', $clienteId)->get();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Debes enviar al menos un cliente_id o cliente_ids en la solicitud.',
            ], 400);
        }

        $logsCreados = [];
        $resultados = [];
        $procesados = 0;
        $pendientes = [];

        foreach ($clientes as $cliente) {
            // $horaActual = Carbon::now('America/Bogota');
            // if ($horaActual->greaterThanOrEqualTo($horaLimite)) {
            //     // Todos los clientes restantes se consideran pendientes
            //     $pendientes = $clientes->slice($procesados)->pluck('id')->toArray();
            //     break;
            // }

            if (empty($cliente->telefono)) {
                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => null,
                    'status' => 'error',
                    'error' => 'El cliente no tiene un número de teléfono válido.',
                ];
                $procesados++;
                continue;
            }

            // Reemplazo de variables dinámicas
            $variables = [
                '{{nombre}}' => $cliente->nombre,
                '{{telefono}}' => $cliente->telefono,
            ];

            $mensajeFinal = str_replace(
                array_keys($variables),
                array_values($variables),
                $mensaje->contenido
            );

            $tituloFinal = $mensaje->titulo;

            $log = LogEnvioMasivo::create([
                'mensaje_masivo_id' => $mensaje->id,
                'cliente_id' => $cliente->id,
                'mensaje_final' => $mensajeFinal,
                'estado' => 'pendiente',
            ]);

            $logsCreados[] = $log->id;

            try {
                $payload = [
                    'numero' => '57' . $cliente->telefono,
                    'titulo' => $tituloFinal,
                    'mensaje' => $mensajeFinal,
                ];

                if ($mensaje->ruta_imagen) {
                    $payload['imagen'] = $mensaje->ruta_imagen;
                }

                \Log::info('Payload enviado a Venom:', $payload);

                $response = Http::timeout(1200)->post('http://localhost:3000/send-message', $payload);

                $log->estado = 'enviado';
                $log->save();

                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => '57' . $cliente->telefono,
                    'status' => $log->estado,
                    'error' => null,
                ];
            } catch (\Exception $e) {
                $log->estado = 'error';
                $log->error = $e->getMessage();
                $log->save();

                $resultados[] = [
                    'cliente_id' => $cliente->id,
                    'numero' => '57' . $cliente->telefono,
                    'status' => 'error',
                    'error' => $e->getMessage(),
                ];
            }

            $procesados++;
            // Delay de 7 segundos entre cada envío
            sleep(7);
        }

        return response()->json([
            'message' => 'Mensajes procesados',
            'logs_creados' => $logsCreados,
            'resultados' => $resultados,
            'pendientes' => $pendientes,
        ]);
    }

    // Actualizar log de envío
    public function actualizarLog($logId, Request $request)
    {
        $log = LogEnvioMasivo::findOrFail($logId);

        $estado = $request->input('estado');
        $error = $request->input('error', null);

        if (!in_array($estado, ['pendiente', 'enviado', 'error'])) {
            return response()->json([
                'success' => false,
                'message' => 'Estado no válido.'
            ], 400);
        }

        $log->estado = $estado;
        if ($estado === 'error') {
            $log->error = $error;
        }
        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Log actualizado correctamente.',
            'log' => $log
        ]);
    }

}
