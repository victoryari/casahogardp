<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombres', 'apellidos', 'tipo_documento', 'numero_documento',
        'fecha_nacimiento', 'contacto_emergencia', 'telefono_emergencia',
        'condicion_medica', 'estado', 'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso'    => 'date',
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_paciente', 'id_paciente');
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->diffInYears(now());
    }
}
