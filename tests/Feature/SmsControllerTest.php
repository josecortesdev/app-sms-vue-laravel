<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

class SmsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Comprobamos que el controlador de los SMS funcione correctamente.
     */
    public function testSendSmsSuccess(): void
    {
        // Mock del servicio de SMS
        $smsServiceMock = Mockery::mock('App\Services\SmsServiceInterface');
        $smsServiceMock->shouldReceive('send')
            ->once()
            ->with(['1234567890'], 'Hola, este es un mensaje de prueba.')
            ->andReturn([
                'status' => 'success',
                'message' => 'SMS enviado correctamente.',
            ]);
            
            // Registrar el mock en el contenedor de Laravel
            $this->app->instance('App\Services\SmsServiceInterface', $smsServiceMock);
            
            // Datos de prueba
            $payload = [
                'phones' => ['1234567890'],
                'message' => 'Hola, este es un mensaje de prueba.',
            ];
        
            // Llamar al endpoint
            $response = $this->postJson('/api/send-sms', $payload);
        
            // Verificar la respuesta
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 'success',
                'message' => 'SMS enviado correctamente.',
            ]);
    }
}
