<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatriculaRequest;
use App\Models\Curso;
use App\Models\Matricula;

class MatriculaController extends Controller
{
    /** Listado de matrículas registradas */
    public function index()
    {
        $matriculas = Matricula::with('curso.carrera')->latest()->paginate(10);

        return view('matriculas.index', compact('matriculas'));
    }

    /** Página principal: formulario de matrícula con el listado de cursos */
    public function create()
    {
        $cursos = Curso::with('carrera')->orderBy('nombre')->get();

        return view('matriculas.create', compact('cursos'));
    }

    /** Guarda la matrícula y muestra el comprobante */
    public function store(MatriculaRequest $request)
    {
        $matricula = Matricula::create($request->validated());

        return redirect()
            ->route('matriculas.show', $matricula)
            ->with('success', 'Matrícula registrada correctamente.');
    }

    /** Muestra los datos del registro de matrícula */
    public function show(Matricula $matricula)
    {
        $matricula->load('curso.carrera');

        return view('matriculas.show', compact('matricula'));
    }
}
