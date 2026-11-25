<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use Illuminate\Support\Facades\Route;

// Página principal: formulario de matrícula
Route::get('/', [MatriculaController::class, 'create'])->name('home');

// Matrículas: listado, guardar y ver comprobante
Route::resource('matriculas', MatriculaController::class)->only(['index', 'store', 'show']);

// CRUD de cursos: index, create, store, show, edit, update, destroy
Route::resource('cursos', CursoController::class);
