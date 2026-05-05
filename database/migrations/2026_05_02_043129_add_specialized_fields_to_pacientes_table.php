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
        Schema::table('pacientes', function (Blueprint $table) {
            $table->text('alergias')->nullable()->after('condicion_medica');
            $table->text('medicamentos_actuales')->nullable()->after('alergias');
            $table->string('contacto_emergencia_nombre')->nullable()->after('medicamentos_actuales');
            $table->string('contacto_emergencia_telefono')->nullable()->after('contacto_emergencia_nombre');
            $table->string('grado_dependencia')->nullable()->after('contacto_emergencia_telefono'); // Independiente, Leve, Moderada, Severa
            $table->string('tipo_dieta')->nullable()->after('grado_dependencia'); // Normal, Hiposódica, Diabética, Blanda
            $table->string('soporte_movilidad')->nullable()->after('tipo_dieta'); // Ninguno, Bastón, Andador, Silla de Ruedas, Postrado
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn([
                'alergias', 'medicamentos_actuales', 'contacto_emergencia_nombre', 
                'contacto_emergencia_telefono', 'grado_dependencia', 'tipo_dieta', 'soporte_movilidad'
            ]);
        });
    }
};
