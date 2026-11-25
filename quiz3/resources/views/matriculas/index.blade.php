@extends('layouts.app')

@section('title', 'Matrículas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Matrículas registradas</h1>
    <a href="{{ route('home') }}" class="btn btn-primary">+ Nueva matrícula</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>N.º</th>
                    <th>Estudiante</th>
                    <th>Cédula</th>
                    <th>Curso</th>
                    <th>Carrera</th>
                    <th>Fecha</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matriculas as $matricula)
                    <tr>
                        <td>{{ str_pad($matricula->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $matricula->estudiante_nombre }}</td>
                        <td>{{ $matricula->estudiante_cedula }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $matricula->curso->codigo }}</span>
                            {{ $matricula->curso->nombre }}
                        </td>
                        <td>{{ $matricula->curso->carrera->nombre }}</td>
                        <td class="text-nowrap">{{ $matricula->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('matriculas.show', $matricula) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Aún no hay matrículas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $matriculas->links('pagination::bootstrap-5') }}
</div>
@endsection
