@php
    $curso = $curso ?? new \App\Models\Curso();
@endphp

@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del curso <span class="text-danger">*</span></label>
    <input type="text" id="nombre" name="nombre" maxlength="120"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $curso->nombre) }}">
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="codigo" class="form-label">Código del curso <span class="text-danger">*</span></label>
        <input type="text" id="codigo" name="codigo" maxlength="20" placeholder="Ej: ISW-101"
               class="form-control text-uppercase @error('codigo') is-invalid @enderror"
               value="{{ old('codigo', $curso->codigo) }}">
        @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="creditos" class="form-label">Cantidad de créditos <span class="text-danger">*</span></label>
        <input type="number" min="1" max="12" id="creditos" name="creditos"
               class="form-control @error('creditos') is-invalid @enderror"
               value="{{ old('creditos', $curso->creditos) }}">
        @error('creditos') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-4">
    <label for="carrera_id" class="form-label">Carrera <span class="text-danger">*</span></label>
    <select id="carrera_id" name="carrera_id"
            class="form-select @error('carrera_id') is-invalid @enderror">
        <option value="">-- Seleccione una carrera --</option>
        @foreach ($carreras as $carrera)
            <option value="{{ $carrera->id }}"
                {{ (string) old('carrera_id', $curso->carrera_id) === (string) $carrera->id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
    @error('carrera_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
