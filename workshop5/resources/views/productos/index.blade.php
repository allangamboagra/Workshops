@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo producto</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th class="text-end">Precio</th>
                    <th class="text-end">Stock</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td class="text-end">${{ number_format($producto->precio, 2) }}</td>
                        <td class="text-end">{{ $producto->stock }}</td>
                        <td>
                            <span class="badge {{ $producto->activo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $productos->links() }}
</div>
@endsection
