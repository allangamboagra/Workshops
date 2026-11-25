@extends('layouts.app')

@section('title', 'Editar curso')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="h3 mb-3">Editar curso {{ $curso->codigo }}</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('cursos.update', $curso) }}" method="POST" novalidate>
                    @method('PUT')
                    @include('cursos._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
