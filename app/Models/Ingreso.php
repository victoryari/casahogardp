<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';
    protected $primaryKey = 'id_ingreso';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_factura', 'id_usuario_registro', 'concepto', 'monto',
        'metodo_pago', 'comprobante_referencia', 'fecha_ingreso', 'estado',
    ];

    protected $casts = ['fecha_ingreso' => 'datetime'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }
}
