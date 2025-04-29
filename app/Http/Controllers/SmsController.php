<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use Illuminate\Http\Request;
use App\Services\SmsServiceInterface;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsServiceInterface $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSms(Request $request)
    {

        \Log::info('Llega al controlador');
        \Log::info($request);

        // Validar los datos de entrada
        $request->validate([
            'phones' => 'required|array|min:1',
            'phones.*' => 'required|string|regex:/^\d{9,15}$/',
            'message' => 'required|string|max:160|not_regex:/^\s*$/',
        ], [
            'phones.required' => 'Debe proporcionar al menos un número de teléfono.',
            'phones.array' => 'El campo de números debe ser un array.',
            'phones.min' => 'Debe proporcionar al menos un número de teléfono.',
            'phones.*.regex' => 'Cada número debe tener entre 9 y 15 dígitos.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max' => 'El mensaje no puede exceder los 160 caracteres.',
            'message.not_regex' => 'El mensaje no puede estar vacío o contener solo espacios.',
        ]);

        try {
            $result = $this->smsService->send($request->phones, $request->message);
            
            // Guardar el historial en la base de datos
            SmsLog::create([
                'phones' => $request->phones,
                'message' => $request->message,
                'status' => $result['status'],
            ]);
            
            return response()->json($result, $result['status'] === 'success' ? 200 : 500);
        } catch (\Exception $e) {
            \Log::error('Error al enviar SMS: ' . $e->getMessage());
            return response()->json(['error' => 'Error al enviar el SMS.'], 500);
        }
    }

    public function getSmsLogs(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $logs = SmsLog::getLogs($filters,10); // 10 registros por página
        return response()->json($logs);
    }

    public function getSmsStats()
    {
        $stats = SmsLog::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
    
        return response()->json($stats);
    }
}