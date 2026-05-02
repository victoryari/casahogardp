<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id_permiso');
            $table->string('nombre_permiso');
            $table->string('llave')->unique();
            $table->string('descripcion')->nullable();
            $table->string('modulo')->nullable();
        });

        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->integer('id_rol');
            $table->unsignedInteger('id_permiso');
            $table->primary(['id_rol', 'id_permiso']);
            $table->foreign('id_rol')->references('id_rol')->on('roles')->onDelete('cascade');
            $table->foreign('id_permiso')->references('id_permiso')->on('permisos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_permiso');
        Schema::dropIfExists('permisos');
    }
};
