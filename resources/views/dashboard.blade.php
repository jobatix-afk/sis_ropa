@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <span class="navbar-brand">
            POS Ropa
        </span>

        <div class="d-flex align-items-center gap-3">

            <span class="text-white">
                {{ auth()->user()->nombre }}
            </span>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button class="btn btn-outline-light btn-sm">
                    Cerrar sesión
                </button>

            </form>

        </div>

    </div>

</nav>

<div class="container py-5">

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <h2 class="fw-bold">
        Bienvenido, {{ auth()->user()->nombre }}
    </h2>

    <p class="text-muted">
        Rol:
        <strong>
            {{ ucfirst(auth()->user()->rol) }}
        </strong>
    </p>

    <hr>

    <div class="row g-4 mt-2">

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Productos</h5>

                    <p class="text-muted">
                        Administración del inventario.
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Punto de Venta</h5>

                    <p class="text-muted">
                        Registrar nuevas ventas.
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Reportes</h5>

                    <p class="text-muted">
                        Consultar ventas y estadísticas.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection