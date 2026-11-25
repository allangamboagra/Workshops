<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            'Ingeniería del Software',
            'Ingeniería en Sistemas de Información',
            'Administración de Empresas',
            'Contaduría Pública',
            'Diseño Gráfico',
        ];

        foreach ($carreras as $nombre) {
            Carrera::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
