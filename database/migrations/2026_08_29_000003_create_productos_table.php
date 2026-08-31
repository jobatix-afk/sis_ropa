<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: productos
 * talla / color / genero son específicos del rubro "Ropa y Accesorios"
 * (opción B). Son nullable para no romper el mínimo pedido en la guía
 * y para que apliquen tanto a ropa (talla/color) como a accesorios.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();
            $table->string('talla', 10)->nullable();
            $table->string('color', 40)->nullable();
            $table->enum('genero', ['hombre', 'mujer', 'unisex', 'nino', 'nina'])->nullable();
            $table->string('imagen_url', 500)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
