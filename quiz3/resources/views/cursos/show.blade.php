@extends('layouts.app')

@section('title', $curso->nombre)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3">{{ $curso->nombre }}</h1>

                <dl class="row mb-4">
                    <dt class="col-sm-4">Código del curso</dt>
                    <dd class="col-sm-8">{{ $curso->codigo }}</dd>

                    <dt class="col-sm-4">Cantidad de créditos</dt>
                    <dd class="col-sm-8">{{ $curso->creditos }}</dd>

                    <dt class="col-sm-4">Carrera</dt>
                    <dd class="col-sm-8">{{ $curso->carrera->nombre }}</dd>

                    <dt class="col-sm-4">Estudiantes matriculados</dt>
                    <dd class="col-sm-8">{{ $curso->matriculas_count }}</dd>

                    <dt class="col-sm-4">Creado</dt>
                    <dd class="col-sm-8">{{ $curso->created_at?->format('d/m/Y H:i') }}</dd>
                </dl>

                <div class="d-flex gap-2">
                    <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
