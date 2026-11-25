@extends('layouts.app')

@section('title', 'Comprobante de matrícula')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Comprobante de matrícula</span>
                <span>N.º {{ str_pad($matricula->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body">
                <h2 class="h5 mb-3">Datos del estudiante</h2>
                <dl class="row mb-4">
                    <dt class="col-sm-4">Nombre</dt>
                    <dd class="col-sm-8">{{ $matricula->estudiante_nombre }}</dd>

                    <dt class="col-sm-4">Cédula</dt>
                    <dd class="col-sm-8">{{ $matricula->estudiante_cedula }}</dd>

                    <dt class="col-sm-4">Correo</dt>
                    <dd class="col-sm-8">{{ $matricula->estudiante_correo }}</dd>
                </dl>

                <h2 class="h5 mb-3">Curso matriculado</h2>
                <dl class="row mb-4">
                    <dt class="col-sm-4">Nombre del curso</dt>
                    <dd class="col-sm-8">{{ $matricula->curso->nombre }}</dd>

                    <dt class="col-sm-4">Código del curso</dt>
                    <dd class="col-sm-8">{{ $matricula->curso->codigo }}</dd>

                    <dt class="col-sm-4">Cantidad de créditos</dt>
                    <dd class="col-sm-8">{{ $matricula->curso->creditos }}</dd>

                    <dt class="col-sm-4">Carrera</dt>
                    <dd class="col-sm-8">{{ $matricula->curso->carrera->nombre }}</dd>
                </dl>

                <p class="text-muted small mb-4">
                    Fecha de matrícula: {{ $matricula->created_at?->format('d/m/Y H:i') }}
                </p>

                <div class="d-flex gap-2">
                    <a href="{{ route('home') }}" class="btn btn-primary">Nueva matrícula</a>
                    <a href="{{ route('matriculas.index') }}" class="btn btn-secondary">Ver matrículas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
