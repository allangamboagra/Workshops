<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('estudiante_nombre', 120);
            $table->string('estudiante_cedula', 20);
            $table->string('estudiante_correo', 120);
            $table->foreignId('curso_id')->constrained('cursos')->restrictOnDelete();
            $table->timestamps();

            // Un estudiante no puede matricular el mismo curso dos veces
            $table->unique(['estudiante_cedula', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
