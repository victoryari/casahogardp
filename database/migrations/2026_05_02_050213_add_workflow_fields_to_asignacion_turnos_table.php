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
        Schema::table('asignacion_turnos', function (Blueprint $table) {
            $table->string('estado_aprobacion', 20)->default('pendiente')->after('id_usuario_asigno'); // pendiente, aprobado, rechazado
            $table->integer('id_usuario_valida')->nullable()->after('estado_aprobacion');
            $table->timestamp('fecha_validacion')->nullable()->after('id_usuario_valida');
            $table->text('comentarios_aprobacion')->nullable()->after('fecha_validacion');
        });
    }

    public function down(): void
    {
        Schema::table('asignacion_turnos', function (Blueprint $table) {
            $table->dropColumn(['estado_aprobacion', 'id_usuario_valida', 'fecha_validacion', 'comentarios_aprobacion']);
        });
    }
};
