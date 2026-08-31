<?php

namespace App\Services;

/**
 * Genera la URL del código QR de una factura usando la API gratuita
 * api.qrserver.com (no requiere API key).
 *
 * Uso típico en el flujo de venta:
 *   $url = (new QrCodeService)->generarUrl($venta->numero_factura);
 *   $venta->update(['qr_url' => $url]);
 */
class QrCodeService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.qr.base_url', 'https://api.qrserver.com/v1/create-qr-code/');
    }

    /**
     * @param  string  $contenido  Texto/dato a codificar (ej. número de factura o URL de la factura)
     * @param  int  $size  Tamaño en píxeles (cuadrado), ej. 200 => 200x200
     */
    public function generarUrl(string $contenido, int $size = 200): string
    {
        $query = http_build_query([
            'size' => "{$size}x{$size}",
            'data' => $contenido,
        ]);

        return "{$this->baseUrl}?{$query}";
    }

    /**
     * Genera la URL del QR apuntando a la vista pública de la factura,
     * útil para que el cliente escanee y vea/descargue su recibo.
     */
    public function generarUrlParaFactura(string $numeroFactura, ?string $urlFacturaPublica = null): string
    {
        $contenido = $urlFacturaPublica ?? $numeroFactura;

        return $this->generarUrl($contenido);
    }
}
