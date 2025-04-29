<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AltiriaSmsService implements SmsServiceInterface
{
    public function send(array $phones, string $message): array
    {
\Log::info('Llega al metodo');
        $url = 'https://www.altiria.net:8443/apirest/ws/sendSms';
        $apiKey = env('ALTIRIA_API_KEY');
        $apiSecret = env('ALTIRIA_API_SECRET');
        $message = mb_convert_encoding($message, 'UTF-8');

        $phones = array_map(function ($phone) {
            // Añadir el prefijo 34 si no está presente
            return str_starts_with($phone, '34') ? $phone : '34' . $phone;
        }, $phones);

        // Configurar el cuerpo de la solicitud en formato JSON
        $payload = [
            'credentials' => [
                'apiKey' => $apiKey,
                'apiSecret' => $apiSecret,
            ],
            'destination' => $phones,
            'message' => [
                'msg' => $message,
                'senderId' => 'Jose', // Remitente personalizado
            ],

        ];
        // Enviar la solicitud a la API de Altiria
        //Solo para desarrollo con el verify (verificar ssl) a false
        $response = Http::withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8',
        ])->withOptions(['verify' => false])->post($url, $payload);

        // Registrar la respuesta para depuración
        \Log::info('Respuesta de Altiria: ' . $response->body());

        if ($response->successful()) {
            return [
                'status' => 'success',
                'response' => $response->body(),
            ];
        }

        return [
            'status' => 'error',
            'response' => $response->body(),
        ];
    }
}