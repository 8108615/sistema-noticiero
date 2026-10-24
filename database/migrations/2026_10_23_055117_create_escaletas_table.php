<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escaletas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha'); // Fecha específica del noticiero
            $table->enum('programa', ['Revista', 'Noticiero Meridiano', 'Noticiero Central']); // El programa de TV
            $table->string('titulo_programa')->nullable(); // Ej: "Edición Central 20:00"
            $table->enum('estado', ['Borrador', 'Aprobado', 'En Aire'])->default('Borrador');
            $table->timestamps();

            // Evitamos duplicados para el mismo programa en la misma fecha
            $table->unique(['fecha', 'programa']);
        });

        // Tabla para las notas individuales dentro de la escaleta del programa
        Schema::create('notas_escaleta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaleta_id')->constrained('escaletas')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('nro_nota'); // Nro Nota
            $table->enum('tipo_nota', ['CUÑA', 'V.O.', 'F.V.', 'Nota', 'Deportes', 'Entrevista']);
            $table->string('nombre_nota'); // Nombre de la Nota
            $table->string('periodista')->nullable(); // Nombre del Periodista
            $table->string('titulo'); // Titulo que sale en pantalla (GC / Zócalo)
            $table->longText('redaccion')->nullable(); // Guion o texto de la noticia
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_escaleta');
        Schema::dropIfExists('escaletas');
    }
};
