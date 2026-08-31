<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['codigo' => 'CAM-001', 'nombre' => 'Camisa Oxford Manga Larga', 'categoria' => 'Camisas', 'precio' => 149.99, 'stock' => 20, 'talla' => 'M', 'color' => 'Celeste', 'genero' => 'hombre'],
            ['codigo' => 'CAM-002', 'nombre' => 'Blusa Casual Estampada', 'categoria' => 'Camisas', 'precio' => 129.50, 'stock' => 15, 'talla' => 'S', 'color' => 'Blanco', 'genero' => 'mujer'],
            ['codigo' => 'PAN-001', 'nombre' => 'Jean Slim Fit', 'categoria' => 'Pantalones', 'precio' => 219.00, 'stock' => 12, 'talla' => '32', 'color' => 'Azul', 'genero' => 'hombre'],
            ['codigo' => 'PAN-002', 'nombre' => 'Pantalón de Vestir', 'categoria' => 'Pantalones', 'precio' => 249.00, 'stock' => 4, 'talla' => '34', 'color' => 'Negro', 'genero' => 'hombre'],
            ['codigo' => 'VES-001', 'nombre' => 'Vestido Casual Floral', 'categoria' => 'Vestidos', 'precio' => 279.99, 'stock' => 8, 'talla' => 'M', 'color' => 'Rosado', 'genero' => 'mujer'],
            ['codigo' => 'CHA-001', 'nombre' => 'Chumpa Impermeable', 'categoria' => 'Chaquetas', 'precio' => 349.00, 'stock' => 3, 'talla' => 'L', 'color' => 'Negro', 'genero' => 'unisex'],
            ['codigo' => 'CAL-001', 'nombre' => 'Tenis Urbano', 'categoria' => 'Calzado', 'precio' => 399.00, 'stock' => 10, 'talla' => '9', 'color' => 'Blanco', 'genero' => 'unisex'],
            ['codigo' => 'ACC-001', 'nombre' => 'Cinturón de Cuero', 'categoria' => 'Accesorios', 'precio' => 89.00, 'stock' => 25, 'talla' => 'Único', 'color' => 'Café', 'genero' => 'unisex'],
            ['codigo' => 'ACC-002', 'nombre' => 'Gorra Bordada', 'categoria' => 'Accesorios', 'precio' => 65.00, 'stock' => 2, 'talla' => 'Único', 'color' => 'Gris', 'genero' => 'unisex'],
        ];

        foreach ($productos as $producto) {
            $categoria = Categoria::where('nombre', $producto['categoria'])->first();

            Producto::updateOrCreate(
                ['codigo' => $producto['codigo']],
                [
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['nombre'].' - '.$producto['categoria'],
                    'precio' => $producto['precio'],
                    'stock' => $producto['stock'],
                    'categoria_id' => $categoria->id,
                    'talla' => $producto['talla'],
                    'color' => $producto['color'],
                    'genero' => $producto['genero'],
                    'imagen_url' => null,
                    'activo' => true,
                ]
            );
        }
    }
}
