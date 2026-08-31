<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Camisas', 'descripcion' => 'Camisas y blusas para hombre y mujer'],
            ['nombre' => 'Pantalones', 'descripcion' => 'Jeans, pantalones de vestir y casuales'],
            ['nombre' => 'Vestidos', 'descripcion' => 'Vestidos casuales y formales'],
            ['nombre' => 'Chaquetas', 'descripcion' => 'Chumpas, chaquetas y abrigos'],
            ['nombre' => 'Calzado', 'descripcion' => 'Zapatos, tenis y sandalias'],
            ['nombre' => 'Accesorios', 'descripcion' => 'Cinturones, gorras, bolsos y bisutería'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }
    }
}
