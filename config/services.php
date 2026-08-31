<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Credenciales de las APIs externas usadas por el POS.
    | (Este archivo reemplaza/complementa el config/services.php estándar
    | de Laravel; conserva ahí las demás entradas que traiga tu instalación,
    | como 'postmark', 'ses', 'resend', etc.)
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // API 1: código QR de la factura (api.qrserver.com, sin API key)
    'qr' => [
        'base_url' => env('QR_API_BASE_URL', 'https://api.qrserver.com/v1/create-qr-code/'),
    ],

    // API 2: envío de factura por SMS/WhatsApp (Twilio)
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    // API 3 (Google Fonts) no necesita credenciales: se referencia
    // directamente desde el <link> del layout, ver
    // resources/views/layouts/app.blade.php

];
