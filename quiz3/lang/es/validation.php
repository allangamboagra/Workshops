<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string'   => 'El campo :attribute debe ser texto.',
    'integer'  => 'El campo :attribute debe ser un número entero.',
    'numeric'  => 'El campo :attribute debe ser un número.',
    'email'    => 'El campo :attribute debe ser un correo válido.',
    'exists'   => 'El :attribute seleccionado no es válido.',
    'unique'   => 'El :attribute ya está registrado.',
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string'  => 'El campo :attribute no debe superar :max caracteres.',
    ],
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
];
