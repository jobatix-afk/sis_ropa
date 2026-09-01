<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
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
   RUTAS PARA INVITADOS
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

    /* Dashboard */
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /* Productos */
    Route::resource(
        'productos',
        ProductoController::class
    );


    /* Clientes */
    Route::resource(
        'clientes',
        ClienteController::class
    );


    /* Cerrar sesión */
    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});