<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescripcion extends Model
{
    protected $table = 'prescripciones';
    protected $primaryKey = 'id_prescripcion';

    protected $fillable = [
        'id_paciente', 'medicamento', 'dosis', 'frecuencia_horas',
        'via_administracion', 'fecha_inicio', 'fecha_fin',
        'indicaciones', 'id_usuario_prescribe', 'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'frecuencia_horas' => 'integer',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function prescribe()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_prescribe', 'id_usuario');
    }

    public function administraciones()
    {
        return $this->hasMany(AdministracionMedicamento::class, 'id_prescripcion', 'id_prescripcion');
    }
}
