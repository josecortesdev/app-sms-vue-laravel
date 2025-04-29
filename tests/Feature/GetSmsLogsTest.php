<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetSmsLogsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test de los logs de SMS .
     */
    public function testGetSmsLogs(): void
    {
        // Crear datos de prueba
        \App\Models\SmsLog::factory()->count(5)->create([
            'status' => 'success',
        ]);
    
        \App\Models\SmsLog::factory()->count(3)->create([
            'status' => 'failed',
        ]);
    
        // Llamar al endpoint sin filtros
        $response = $this->getJson('/api/sms-logs');
    
        // Verificar la respuesta
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'phones', 'message', 'status', 'created_at', 'updated_at'],
            ],
        ]);
    
        // Llamar al endpoint con filtros
        $response = $this->getJson('/api/sms-logs?status=success');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data'); // Verificar que solo se devuelvan los registros con estado "success"
    }
    public function testGetSmsLogsNoRecords(): void
    {
        // Llamar al endpoint sin registros en la base de datos
        $response = $this->getJson('/api/sms-logs');

        // Verificar que la respuesta sea correcta
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data'); // No debe haber registros
    }
    public function testGetSmsLogsDateFilters(): void
    {
        // Crear registros con diferentes fechas
        \App\Models\SmsLog::factory()->create(['created_at' => now()->subDays(2)]);
        \App\Models\SmsLog::factory()->create(['created_at' => now()->subDays(1)]);
        \App\Models\SmsLog::factory()->create(['created_at' => now()]);

        // Llamar al endpoint con un rango de fechas
        $response = $this->getJson('/api/sms-logs?date_from=' . now()->subDays(2)->toDateTimeString() . '&date_to=' . now()->subDays(1)->toDateTimeString());

        // Verificar la respuesta
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Solo deben devolverse los registros dentro del rango
    }
    public function testGetSmsLogsInvalidFilters(): void
    {
        // Llamar al endpoint con filtros inválidos
        $response = $this->getJson('/api/sms-logs?status=invalid_status');

        // Verificar que no cause un error y devuelva una respuesta vacía
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }
}
