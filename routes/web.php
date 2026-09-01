<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;


/* =========================================================
   RUTA PRINCIPAL
   ========================================================= */

Route::get('/', function () {

    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');

});


/* =========================================================
   USUARIOS INVITADOS
   ========================================================= */

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');


    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.process');


    Route::get(
        '/registro',
        [AuthController::class, 'showRegister']
    )->name('register');


    Route::post(
        '/registro',
        [AuthController::class, 'register']
    )->name('register.store');

});


/* =========================================================
   RUTAS PROTEGIDAS
   ========================================================= */

Route::middleware('auth')->group(function () {


    /* =====================================================
       DASHBOARD
       ===================================================== */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /* =====================================================
       PRODUCTOS
       ===================================================== */

    Route::resource(
        'productos',
        ProductoController::class
    );


    /* =====================================================
       CLIENTES
       ===================================================== */

    Route::resource(
        'clientes',
        ClienteController::class
    );


    /* =====================================================
       PUNTO DE VENTA
       ===================================================== */

    // Pantalla principal del POS
    Route::get(
        '/pos',
        [VentaController::class, 'create']
    )->name('ventas.create');


    // Registrar una venta
    Route::post(
        '/ventas',
        [VentaController::class, 'store']
    )->name('ventas.store');


    // Mostrar factura / recibo
    Route::get(
        '/ventas/{venta}',
        [VentaController::class, 'show']
    )->name('ventas.show');


    /* =====================================================
       CERRAR SESIÓN
       ===================================================== */

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});