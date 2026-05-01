<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionEmpresa extends Model
{
    protected $table = 'configuracion_empresa';
    protected $primaryKey = 'id_config';
    public $timestamps = false;

    protected $fillable = ['ruc', 'razon_social', 'nombre_comercial', 'direccion', 'telefono', 'correo', 'moneda'];

    public static function actual(): self
    {
        return static::firstOrNew([], [
            'ruc' => '', 'razon_social' => 'CasaHogar',
            'nombre_comercial' => 'CasaHogar', 'moneda' => 'PEN',
        ]);
    }
}
