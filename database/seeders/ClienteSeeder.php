<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::updateOrCreate(
            ['nit' => 'CF'],
            ['nombre' => 'Consumidor Final', 'correo' => null, 'telefono' => null, 'direccion' => null]
        );

        Cliente::updateOrCreate(
            ['nit' => '1234567-8'],
            [
                'nombre' => 'María López',
                'correo' => 'maria.lopez@example.com',
                'telefono' => '50212345678',
                'direccion' => 'Zona 10, Ciudad de Guatemala',
            ]
        );
    }
}
