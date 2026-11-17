<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;

class ProductoController extends Controller
{
    /** Listado de productos */
    public function index()
    {
        $productos = Producto::latest()->paginate(10);

        return view('productos.index', compact('productos'));
    }

    /** Formulario de creación */
    public function create()
    {
        return view('productos.create');
    }

    /** Guarda un nuevo producto */
    public function store(ProductoRequest $request)
    {
        $data = $request->validated();
        $data['activo'] = $request->boolean('activo');

        Producto::create($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /** Detalle de un producto */
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /** Formulario de edición */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /** Actualiza un producto */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();
        $data['activo'] = $request->boolean('activo');

        $producto->update($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /** Elimina un producto */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
