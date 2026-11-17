@php
    $producto = $producto ?? new \App\Models\Producto(['activo' => true]);
@endphp

@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
    <input type="text" id="nombre" name="nombre" maxlength="120"
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $producto->nombre) }}">
    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3"
              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $producto->descripcion) }}</textarea>
    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0" id="precio" name="precio"
               class="form-control @error('precio') is-invalid @enderror"
               value="{{ old('precio', $producto->precio) }}">
        @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
        <input type="number" min="0" id="stock" name="stock"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $producto->stock) }}">
        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-check mb-4">
    <input type="checkbox" id="activo" name="activo" value="1" class="form-check-input"
           {{ old('activo', $producto->activo) ? 'checked' : '' }}>
    <label for="activo" class="form-check-label">Producto activo</label>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
