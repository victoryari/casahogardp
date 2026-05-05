<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionTurno extends Model
{
    protected $table = 'asignacion_turnos';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_personal', 'id_usuario_asigno', 'fecha_turno', 'hora_inicio', 'hora_fin', 'estado',
        'estado_aprobacion', 'id_usuario_valida', 'fecha_validacion', 'comentarios_aprobacion'
    ];

    protected $casts = [
        'fecha_turno' => 'date',
        'fecha_validacion' => 'datetime',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id_personal');
    }

    public function usuarioAsigno()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_asigno', 'id_usuario');
    }

    public function usuarioValida()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_valida', 'id_usuario');
    }
}
