<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Carrera;
use App\Models\Curso;

class CursoController extends Controller
{
    /** Listado de cursos */
    public function index()
    {
        $cursos = Curso::with('carrera')->orderBy('codigo')->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    /** Formulario de creación */
    public function create()
    {
        $carreras = Carrera::orderBy('nombre')->get();

        return view('cursos.create', compact('carreras'));
    }

    /** Guarda un nuevo curso */
    public function store(CursoRequest $request)
    {
        Curso::create($request->validated());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    /** Detalle de un curso */
    public function show(Curso $curso)
    {
        $curso->load('carrera')->loadCount('matriculas');

        return view('cursos.show', compact('curso'));
    }

    /** Formulario de edición */
    public function edit(Curso $curso)
    {
        $carreras = Carrera::orderBy('nombre')->get();

        return view('cursos.edit', compact('curso', 'carreras'));
    }

    /** Actualiza un curso */
    public function update(CursoRequest $request, Curso $curso)
    {
        $curso->update($request->validated());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    /** Elimina un curso (solo si no tiene matrículas) */
    public function destroy(Curso $curso)
    {
        if ($curso->matriculas()->exists()) {
            return redirect()
                ->route('cursos.index')
                ->with('error', 'No se puede eliminar el curso porque tiene estudiantes matriculados.');
        }

        $curso->delete();

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}
