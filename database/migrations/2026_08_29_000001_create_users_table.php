<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: usuarios (users)
 * Guarda a los usuarios del sistema (Administrador / Cajero).
 * Laravel usa por convención el nombre de tabla "users" y la columna
 * "password" (ya hasheada con bcrypt) para que el sistema de auth
 * funcione sin configuración extra.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('correo', 150)->unique();
            $table->string('password'); // password_hash (bcrypt)
            $table->enum('rol', ['administrador', 'cajero'])->default('cajero');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
