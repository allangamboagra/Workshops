@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="h3 mb-3">Editar producto #{{ $producto->id }}</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('productos.update', $producto) }}" method="POST" novalidate>
                    @method('PUT')
                    @include('productos._form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
