<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministracionMedicamento extends Model
{
    protected $table = 'administraciones_medicamentos';
    protected $primaryKey = 'id_administracion';

    protected $fillable = [
        'id_prescripcion', 'fecha_hora_programada', 'fecha_hora_real',
        'id_usuario_administra', 'estado', 'observaciones'
    ];

    protected $casts = [
        'fecha_hora_programada' => 'datetime',
        'fecha_hora_real' => 'datetime',
    ];

    public function prescripcion()
    {
        return $this->belongsTo(Prescripcion::class, 'id_prescripcion', 'id_prescripcion');
    }

    public function administra()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_administra', 'id_usuario');
    }
}
