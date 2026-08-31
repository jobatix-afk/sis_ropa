<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['correo' => 'admin@posropa.test'],
            [
                'nombre' => 'Administrador General',
                'password' => Hash::make('Admin123!'),
                'rol' => 'administrador',
            ]
        );

        User::updateOrCreate(
            ['correo' => 'cajero@posropa.test'],
            [
                'nombre' => 'Cajero Uno',
                'password' => Hash::make('Cajero123!'),
                'rol' => 'cajero',
            ]
        );
    }
}
