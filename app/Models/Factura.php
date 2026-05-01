<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_paciente', 'id_usuario_registro', 'serie', 'correlativo',
        'fecha_emision', 'subtotal', 'impuestos', 'total', 'estado',
    ];

    protected $casts = ['fecha_emision' => 'datetime'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'id_factura', 'id_factura');
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'id_factura', 'id_factura');
    }
}
