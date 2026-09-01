@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')

<div class="container py-5 productos-page">

    <div class="row justify-content-center">

        <div class="col-12 col-xl-10">

            {{-- Encabezado --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 productos-header">

                <div>

                    <span class="productos-eyebrow">
                        Inventario
                    </span>

                    <h1 class="productos-title">
                        Detalle del producto
                    </h1>

                    <p class="productos-subtitle mb-0">
                        Consulta la información completa de la prenda o accesorio seleccionado.
                    </p>

                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="{{ route('productos.index') }}"
                        class="btn-producto-cancel"
                    >
                        ← Volver
                    </a>

                    <a
                        href="{{ route('productos.edit', $producto) }}"
                        class="btn-producto-primary"
                    >
                        Editar producto
                    </a>

                </div>

            </div>


            <div class="producto-form-card">

                <div class="producto-form-section">

                    <div class="row g-5 align-items-start">

                        {{-- Imagen --}}
                        <div class="col-lg-4">

                            @if($producto->imagen_url)

                                <img
                                    src="{{ asset('storage/' . $producto->imagen_url) }}"
                                    alt="{{ $producto->nombre }}"
                                    class="img-fluid w-100 rounded-4 shadow-sm"
                                >

                            @else

                                <div class="producto-image-upload">

                                    <span class="producto-image-icon">
                                        👕
                                    </span>

                                    <div class="producto-image-title">
                                        Sin imagen
                                    </div>

                                    <div class="producto-image-description mb-0">
                                        Este producto todavía no tiene una fotografía registrada.
                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- Información --}}
                        <div class="col-lg-8">

                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 mb-4">

                                <div>

                                    <h2 class="fw-bold mb-1">
                                        {{ $producto->nombre }}
                                    </h2>

                                    <span class="producto-codigo">
                                        {{ $producto->codigo }}
                                    </span>

                                </div>

                                <div>

                                    @if($producto->activo)

                                        <span class="badge text-bg-success producto-badge">
                                            Activo
                                        </span>

                                    @else

                                        <span class="badge text-bg-secondary producto-badge">
                                            Inactivo
                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="row g-3 mb-4">

                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Precio
                                        </span>

                                        <span class="producto-mobile-value">
                                            Q{{ number_format($producto->precio, 2) }}
                                        </span>

                                    </div>

                                </div>


                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Stock
                                        </span>

                                        <span class="producto-mobile-value">

                                            @if($producto->stock_bajo)

                                                <span class="text-danger">
                                                    {{ $producto->stock }} unidades
                                                </span>

                                            @elseif($producto->stock <= 10)

                                                <span class="text-warning">
                                                    {{ $producto->stock }} unidades
                                                </span>

                                            @else

                                                <span class="text-success">
                                                    {{ $producto->stock }} unidades
                                                </span>

                                            @endif

                                        </span>

                                    </div>

                                </div>


                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Categoría
                                        </span>

                                        <span class="producto-mobile-value">
                                            {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                        </span>

                                    </div>

                                </div>


                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Talla
                                        </span>

                                        <span class="producto-mobile-value">
                                            {{ $producto->talla ?: 'No aplica' }}
                                        </span>

                                    </div>

                                </div>


                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Color
                                        </span>

                                        <span class="producto-mobile-value">
                                            {{ $producto->color ?: 'No especificado' }}
                                        </span>

                                    </div>

                                </div>


                                <div class="col-sm-6 col-md-4">

                                    <div class="producto-mobile-field">

                                        <span class="producto-mobile-label">
                                            Género
                                        </span>

                                        <span class="producto-mobile-value">

                                            @if($producto->genero === 'nino')
                                                Niño
                                            @elseif($producto->genero === 'nina')
                                                Niña
                                            @elseif($producto->genero)
                                                {{ ucfirst($producto->genero) }}
                                            @else
                                                No aplica
                                            @endif

                                        </span>

                                    </div>

                                </div>

                            </div>


                            <div>

                                <span class="producto-mobile-label mb-2">
                                    Descripción
                                </span>

                                <div class="p-3 rounded-3 bg-light">

                                    <p class="mb-0 text-secondary">
                                        {{ $producto->descripcion ?: 'Este producto no tiene una descripción registrada.' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection