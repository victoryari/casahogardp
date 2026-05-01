<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitacoraSistema extends Model
{
    protected $table = 'bitacora_sistema';
    protected $primaryKey = 'id_bitacora';
    public $timestamps = false;

    const CREATED_AT = 'fecha_hora';
    const UPDATED_AT = null;

    protected $fillable = ['id_usuario', 'accion', 'tabla_afectada', 'registro_id', 'descripcion'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public static function registrar(string $accion, string $tabla, ?int $registroId = null, ?string $descripcion = null): void
    {
        static::create([
            'id_usuario'     => auth()->id(),
            'accion'         => $accion,
            'tabla_afectada' => $tabla,
            'registro_id'    => $registroId,
            'descripcion'    => $descripcion,
        ]);
    }
}
