<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProspectoMarketing extends Model
{
    protected $table = 'prospectos_marketing';
    protected $primaryKey = 'id_prospecto';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'nombre_contacto', 'telefono', 'correo', 'medio_contacto',
        'interes_mostrado', 'estado_seguimiento', 'estado',
    ];
}
