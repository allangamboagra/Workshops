@extends('layouts.app')

@section('title', 'Matrícula de estudiantes')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <h1 class="h3 mb-3">Matrícula de estudiantes</h1>

        <form action="{{ route('matriculas.store') }}" method="POST" novalidate autocomplete="on">
            @csrf

            {{-- Datos del estudiante --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">1. Datos del estudiante</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="estudiante_nombre" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" id="estudiante_nombre" name="estudiante_nombre" maxlength="120" autocomplete="name"
                               class="form-control @error('estudiante_nombre') is-invalid @enderror"
                               value="{{ old('estudiante_nombre') }}">
                        @error('estudiante_nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="estudiante_cedula" class="form-label">Cédula <span class="text-danger">*</span></label>
                            <input type="text" id="estudiante_cedula" name="estudiante_cedula" maxlength="20" placeholder="Ej: 1-1234-5678"
                                   class="form-control @error('estudiante_cedula') is-invalid @enderror"
                                   value="{{ old('estudiante_cedula') }}">
                            @error('estudiante_cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="estudiante_correo" class="form-label">Correo <span class="text-danger">*</span></label>
                            <input type="email" id="estudiante_correo" name="estudiante_correo" maxlength="120" autocomplete="email"
                                   class="form-control @error('estudiante_correo') is-invalid @enderror"
                                   value="{{ old('estudiante_correo') }}">
                            @error('estudiante_correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listado de cursos --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">2. Seleccione un curso</div>
                <div class="card-body">
                    <input type="search" id="buscar-curso" class="form-control mb-3" autocomplete="off"
                           placeholder="Buscar por nombre, código o carrera...">

                    @error('curso_id')
                        <div class="alert alert-danger py-2">{{ $message }}</div>
                    @enderror

                    <div class="list-group" id="lista-cursos" style="max-height: 360px; overflow-y: auto;">
                        @forelse ($cursos as $curso)
                            <label class="list-group-item list-group-item-action d-flex gap-3 align-items-center curso-item"
                                   data-texto="{{ strtolower($curso->codigo.' '.$curso->nombre.' '.$curso->carrera->nombre) }}">
                                <input class="form-check-input flex-shrink-0" type="radio" name="curso_id"
                                       value="{{ $curso->id }}" {{ (string) old('curso_id') === (string) $curso->id ? 'checked' : '' }}>
                                <span class="flex-grow-1">
                                    <strong>{{ $curso->nombre }}</strong>
                                    <small class="d-block text-muted">{{ $curso->carrera->nombre }}</small>
                                </span>
                                <span class="text-end text-nowrap">
                                    <span class="badge bg-dark">{{ $curso->codigo }}</span>
                                    <small class="d-block text-muted">{{ $curso->creditos }} créditos</small>
                                </span>
                            </label>
                        @empty
                            <div class="list-group-item text-center text-muted py-4">No hay cursos disponibles.</div>
                        @endforelse
                    </div>
                    <div id="sin-resultados" class="text-center text-muted py-3 d-none">Ningún curso coincide con la búsqueda.</div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">Matricular</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filtro (autocomplete) del listado de cursos
    const buscador = document.getElementById('buscar-curso');
    const items = document.querySelectorAll('.curso-item');
    const sinResultados = document.getElementById('sin-resultados');

    buscador.addEventListener('input', () => {
        const termino = buscador.value.trim().toLowerCase();
        let visibles = 0;

        items.forEach(item => {
            const coincide = item.dataset.texto.includes(termino);
            item.classList.toggle('d-none', !coincide);
            if (coincide) visibles++;
        });

        sinResultados.classList.toggle('d-none', visibles > 0 || items.length === 0);
    });
</script>
@endpush
