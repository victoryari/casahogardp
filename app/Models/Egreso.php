<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';
    protected $primaryKey = 'id_egreso';
    public $timestamps = false;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_usuario_registro', 'concepto', 'categoria', 'monto',
        'metodo_pago', 'comprobante_referencia', 'fecha_egreso', 'estado',
    ];

    protected $casts = ['fecha_egreso' => 'datetime'];

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }
}
