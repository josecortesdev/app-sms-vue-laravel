<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'phones',
        'message',
        'status',
    ];

    protected $casts = [
        'phones' => 'array', // Convierte automáticamente el JSON de la base de datos a un array
    ];

    public static function getLogs($filters = [], $perPage = 10)
    {
        $query = self::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    
        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
