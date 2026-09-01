@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card shadow border-0" style="max-width: 450px; width: 100%;">

        <div class="card-body p-5">

            <div class="text-center mb-4">
                <h2 class="fw-bold">POS Ropa</h2>
                <p class="text-muted">Inicia sesión para continuar</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>

                    <input
                        type="email"
                        name="correo"
                        class="form-control"
                        value="{{ old('correo') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                    >

                    <label class="form-check-label" for="remember">
                        Recordarme
                    </label>

                </div>

                <button class="btn btn-dark w-100">
                    Iniciar sesión
                </button>

            </form>

            <div class="text-center mt-4">

                <span class="text-muted">
                    ¿No tienes una cuenta?
                </span>

                <a href="{{ route('register') }}">
                    Registrarse
                </a>

            </div>

        </div>

    </div>

</div>

@endsection