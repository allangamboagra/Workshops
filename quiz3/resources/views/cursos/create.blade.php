@extends('layouts.app')

@section('title', 'Nuevo curso')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="h3 mb-3">Nuevo curso</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('cursos.store') }}" method="POST" novalidate>
                    @include('cursos._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
