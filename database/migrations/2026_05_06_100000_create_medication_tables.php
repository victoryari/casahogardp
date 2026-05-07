<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prescripciones', function (Blueprint $table) {
            $table->id('id_prescripcion');
            $table->integer('id_paciente');
            $table->string('medicamento');
            $table->string('dosis');
            $table->integer('frecuencia_horas');
            $table->string('via_administracion');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->text('indicaciones')->nullable();
            $table->integer('id_usuario_prescribe');
            $table->enum('estado', ['activa', 'finalizada', 'cancelada'])->default('activa');
            $table->timestamps();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes');
            $table->foreign('id_usuario_prescribe')->references('id_usuario')->on('usuarios');
        });

        Schema::create('administraciones_medicamentos', function (Blueprint $table) {
            $table->id('id_administracion');
            $table->foreignId('id_prescripcion')->constrained('prescripciones', 'id_prescripcion')->onDelete('cascade');
            $table->dateTime('fecha_hora_programada');
            $table->dateTime('fecha_hora_real')->nullable();
            $table->integer('id_usuario_administra')->nullable();
            $table->enum('estado', ['pendiente', 'administrado', 'omitido', 'rechazado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario_administra')->references('id_usuario')->on('usuarios');
        });
    }

    public function down()
    {
        Schema::dropIfExists('administraciones_medicamentos');
        Schema::dropIfExists('prescripciones');
    }
};
