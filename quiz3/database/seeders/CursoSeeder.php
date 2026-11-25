<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // [código, nombre, créditos, carrera]
        $cursos = [
            ['ISW-101', 'Introducción a la Programación', 4, 'Ingeniería del Software'],
            ['ISW-211', 'Programación Web I', 4, 'Ingeniería del Software'],
            ['ISW-311', 'Programación Web II', 4, 'Ingeniería del Software'],
            ['ISW-221', 'Bases de Datos I', 3, 'Ingeniería del Software'],
            ['SIS-102', 'Fundamentos de Sistemas de Información', 3, 'Ingeniería en Sistemas de Información'],
            ['SIS-230', 'Redes de Computadoras', 4, 'Ingeniería en Sistemas de Información'],
            ['ADM-101', 'Introducción a la Administración', 3, 'Administración de Empresas'],
            ['ADM-205', 'Mercadeo I', 3, 'Administración de Empresas'],
            ['CON-110', 'Contabilidad General I', 4, 'Contaduría Pública'],
            ['CON-220', 'Costos I', 3, 'Contaduría Pública'],
            ['DIG-101', 'Dibujo Básico', 2, 'Diseño Gráfico'],
            ['DIG-210', 'Teoría del Color', 3, 'Diseño Gráfico'],
        ];

        foreach ($cursos as [$codigo, $nombre, $creditos, $carrera]) {
            Curso::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'nombre'     => $nombre,
                    'creditos'   => $creditos,
                    'carrera_id' => Carrera::where('nombre', $carrera)->value('id'),
                ]
            );
        }
    }
}
