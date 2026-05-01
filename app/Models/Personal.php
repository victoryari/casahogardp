<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'id_personal';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombres', 'apellidos', 'tipo_documento', 'numero_documento',
        'cargo', 'modalidad_contrato', 'telefono', 'estado',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_personal', 'id_personal');
    }

    public function turnos()
    {
        return $this->hasMany(AsignacionTurno::class, 'id_personal', 'id_personal');
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
