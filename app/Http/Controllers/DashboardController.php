<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de productos registrados
        $totalProductos = Producto::count();

        // Productos activos
        $productosActivos = Producto::where('activo', true)->count();

        // Productos con menos de 5 unidades
        $stockBajo = Producto::where('stock', '<', 5)
            ->where('activo', true)
            ->count();

        // Total de categorías
        $totalCategorias = Categoria::count();

        // Valor aproximado del inventario
        $valorInventario = Producto::where('activo', true)
            ->selectRaw('SUM(precio * stock) as total')
            ->value('total') ?? 0;

        // Últimos productos registrados
        $ultimosProductos = Producto::with('categoria')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProductos',
            'productosActivos',
            'stockBajo',
            'totalCategorias',
            'valorInventario',
            'ultimosProductos'
        ));
    }
}