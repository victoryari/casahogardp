<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = ['codigo_servicio', 'nombre_servicio', 'descripcion', 'precio_referencial', 'estado'];

    public function detallesFactura()
    {
        return $this->hasMany(DetalleFactura::class, 'id_servicio', 'id_servicio');
    }
}
