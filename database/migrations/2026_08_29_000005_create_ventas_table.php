<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: ventas
 * numero_factura: correlativo único que se usa como "data" del código QR
 * (api.qrserver.com) y como referencia al enviar la factura por Twilio.
 * qr_url: guarda la URL de la imagen QR ya generada, para no regenerarla
 * cada vez que se reimprime el recibo.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura', 30)->unique();
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();
            $table->dateTime('fecha');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('iva', 10, 2)->default(0); // 12%
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'qr', 'transferencia'])->default('efectivo');
            $table->enum('estado', ['completada', 'anulada', 'pendiente'])->default('completada');
            $table->string('qr_url', 500)->nullable();
            $table->timestamps();

            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
