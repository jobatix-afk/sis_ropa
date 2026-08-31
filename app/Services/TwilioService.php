<?php

namespace App\Services;

use App\Models\EnvioNotificacion;
use App\Models\Venta;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

/**
 * Envía la factura por SMS (o WhatsApp) usando Twilio, y deja registro
 * en la tabla envios_notificacion para poder auditar/reintentar envíos.
 *
 * Requiere en .env: TWILIO_SID, TWILIO_AUTH_TOKEN, TWILIO_FROM
 * (ver config/services.php). Instalar el SDK con:
 *   composer require twilio/sdk
 */
class TwilioService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->from = config('services.twilio.from');
    }

    public function enviarFactura(Venta $venta, string $telefonoDestino, string $canal = 'sms'): EnvioNotificacion
    {
        $envio = EnvioNotificacion::create([
            'venta_id' => $venta->id,
            'canal' => $canal,
            'destino' => $telefonoDestino,
            'estado' => 'pendiente',
        ]);

        $mensaje = "Gracias por su compra. Factura #{$venta->numero_factura} por Q{$venta->total}. "
            .($venta->qr_url ? "Ver QR: {$venta->qr_url}" : '');

        try {
            $to = $canal === 'whatsapp' ? "whatsapp:{$telefonoDestino}" : $telefonoDestino;
            $from = $canal === 'whatsapp' ? "whatsapp:{$this->from}" : $this->from;

            $message = $this->client->messages->create($to, [
                'from' => $from,
                'body' => $mensaje,
            ]);

            $envio->update([
                'estado' => 'enviado',
                'twilio_sid' => $message->sid,
                'fecha' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error enviando factura por Twilio: '.$e->getMessage());

            $envio->update([
                'estado' => 'fallido',
                'mensaje_error' => $e->getMessage(),
                'fecha' => now(),
            ]);
        }

        return $envio->fresh();
    }
}
