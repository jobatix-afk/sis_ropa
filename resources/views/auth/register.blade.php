@extends('layouts.app')

@section('title', 'Registro')

@section('content')

<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card shadow border-0" style="max-width: 500px; width: 100%;">

        <div class="card-body p-5">

            <div class="text-center mb-4">
                <h2 class="fw-bold">Crear cuenta</h2>
                <p class="text-muted">POS Tienda de Ropa</p>
            </div>

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST" action="{{ route('register.store') }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="{{ old('nombre') }}"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Correo
                    </label>

                    <input
                        type="email"
                        name="correo"
                        class="form-control"
                        value="{{ old('correo') }}"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Confirmar contraseña
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required
                    >

                </div>

                <button class="btn btn-dark w-100">
                    Crear cuenta
                </button>

            </form>

            <div class="text-center mt-4">

                <a href="{{ route('login') }}">
                    Ya tengo una cuenta
                </a>

            </div>

        </div>

    </div>

</div>

@endsection