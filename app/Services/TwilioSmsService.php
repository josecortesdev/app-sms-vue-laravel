<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioSmsService implements SmsServiceInterface
{
    public function send(string $phone, string $message): array
    {
        // Configurar Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        // SOLO PARA DESARROLLO. MODIFICAR EN PRODUCCIÓN
        // Configurar opciones para deshabilitar la verificación de SSL
        $twilio->setHttpClient(new \Twilio\Http\CurlClient([
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]));

        // Enviar el mensaje
        $message = $twilio->messages->create($phone, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $message,
        ]);

        // Retornar la respuesta
        return [
            'status' => 'success',
            'sid' => $message->sid,
        ];
    }
}