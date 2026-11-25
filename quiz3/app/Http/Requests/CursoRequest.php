<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // En edición, ignorar el propio curso al validar el código único
        $cursoId = $this->route('curso')?->id;

        return [
            'nombre'     => ['required', 'string', 'max:120'],
            'codigo'     => ['required', 'string', 'max:20', Rule::unique('cursos', 'codigo')->ignore($cursoId)],
            'creditos'   => ['required', 'integer', 'min:1', 'max:12'],
            'carrera_id' => ['required', 'integer', 'exists:carreras,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'     => 'nombre del curso',
            'codigo'     => 'código del curso',
            'creditos'   => 'cantidad de créditos',
            'carrera_id' => 'carrera',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('codigo')) {
            $this->merge(['codigo' => strtoupper(trim($this->input('codigo')))]);
        }
    }
}
