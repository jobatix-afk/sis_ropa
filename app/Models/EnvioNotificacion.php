<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvioNotificacion extends Model
{
    protected $table = 'envios_notificacion';

    protected $fillable = [
        'venta_id',
        'canal',
        'destino',
        'estado',
        'twilio_sid',
        'mensaje_error',
        'fecha',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
