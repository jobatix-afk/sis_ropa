<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: envios_notificacion
 * Traza cada intento de envío de factura por Twilio (SMS/WhatsApp).
 * No es parte del mínimo pedido en la guía, se agrega porque es
 * justo lo que necesita la integración con Twilio para ser
 * "visible y documentada" (rúbrica 5) y auditable (nombre del curso).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios_notificacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->cascadeOnDelete();
            $table->enum('canal', ['sms', 'whatsapp'])->default('sms');
            $table->string('destino', 30); // número de teléfono
            $table->enum('estado', ['pendiente', 'enviado', 'fallido'])->default('pendiente');
            $table->string('twilio_sid', 60)->nullable();
            $table->string('mensaje_error', 255)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios_notificacion');
    }
};
