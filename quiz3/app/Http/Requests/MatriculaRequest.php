<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_nombre' => ['required', 'string', 'max:120'],
            'estudiante_cedula' => ['required', 'string', 'max:20'],
            'estudiante_correo' => ['required', 'email', 'max:120'],
            'curso_id'          => [
                'required',
                'integer',
                'exists:cursos,id',
                // Evita matricular el mismo curso dos veces con la misma cédula
                Rule::unique('matriculas', 'curso_id')
                    ->where('estudiante_cedula', $this->input('estudiante_cedula')),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'estudiante_nombre' => 'nombre del estudiante',
            'estudiante_cedula' => 'cédula',
            'estudiante_correo' => 'correo',
            'curso_id'          => 'curso',
        ];
    }

    public function messages(): array
    {
        return [
            'curso_id.unique' => 'Este estudiante ya está matriculado en el curso seleccionado.',
        ];
    }
}
