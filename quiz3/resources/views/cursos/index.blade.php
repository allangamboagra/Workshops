@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Cursos</h1>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary">+ Nuevo curso</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Nombre del curso</th>
                    <th class="text-center">Créditos</th>
                    <th>Carrera</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cursos as $curso)
                    <tr>
                        <td><span class="badge bg-dark">{{ $curso->codigo }}</span></td>
                        <td>{{ $curso->nombre }}</td>
                        <td class="text-center">{{ $curso->creditos }}</td>
                        <td>{{ $curso->carrera->nombre }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('cursos.show', $curso) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este curso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay cursos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $cursos->links('pagination::bootstrap-5') }}
</div>
@endsection
