<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table = 'detalle_factura';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = ['id_factura', 'id_servicio', 'cantidad', 'precio_unitario', 'subtotal', 'estado'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura', 'id_factura');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}
