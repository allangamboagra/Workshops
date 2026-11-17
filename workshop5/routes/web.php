<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/productos');

// Genera las 7 rutas REST: index, create, store, show, edit, update, destroy
Route::resource('productos', ProductoController::class);
