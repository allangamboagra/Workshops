@extends('layouts.app')

@section('title', $producto->nombre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3">{{ $producto->nombre }}</h1>
                <p class="text-muted">{{ $producto->descripcion ?: 'Sin descripción.' }}</p>

                <dl class="row mb-4">
                    <dt class="col-sm-3">Precio</dt>
                    <dd class="col-sm-9">${{ number_format($producto->precio, 2) }}</dd>

                    <dt class="col-sm-3">Stock</dt>
                    <dd class="col-sm-9">{{ $producto->stock }}</dd>

                    <dt class="col-sm-3">Estado</dt>
                    <dd class="col-sm-9">{{ $producto->activo ? 'Activo' : 'Inactivo' }}</dd>

                    <dt class="col-sm-3">Creado</dt>
                    <dd class="col-sm-9">{{ $producto->created_at->format('d/m/Y H:i') }}</dd>
                </dl>

                <div class="d-flex gap-2">
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
