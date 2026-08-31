<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - POS Ropa
|--------------------------------------------------------------------------
|
| Base de arranque para la Tarea 2/3 (auth + CRUD). Se deja solo la ruta
| de salud y el bloque de auth comentado como guía; los controladores
| (AuthController, ProductoController, VentaController, ReporteController)
| se agregan en la siguiente entrega según el cronograma del curso.
|
| Endpoints mínimos que pide la guía (Sección 5.5), a implementar aquí:
|   GET    /api/productos
|   POST   /api/productos
|   PUT    /api/productos/{id}
|   DELETE /api/productos/{id}
|   POST   /api/ventas
|   GET    /api/reportes/ventas
|
*/

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app' => config('app.name'),
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Route::post('/login', [AuthController::class, 'login']);
//
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::apiResource('productos', ProductoController::class);
//     Route::apiResource('clientes', ClienteController::class);
//     Route::post('/ventas', [VentaController::class, 'store']);
//     Route::get('/ventas/{venta}', [VentaController::class, 'show']);
//     Route::get('/reportes/ventas', [ReporteController::class, 'ventas']);
//     Route::get('/reportes/productos-mas-vendidos', [ReporteController::class, 'productosMasVendidos']);
// });
