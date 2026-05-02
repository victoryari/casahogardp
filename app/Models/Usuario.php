<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = ['id_rol', 'id_personal', 'nombre_usuario', 'password_hash', 'estado'];
    protected $hidden   = ['password_hash'];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'id_personal', 'id_personal');
    }

    public function tieneRol(string $nombreRol): bool
    {
        return optional($this->rol)->nombre_rol === $nombreRol;
    }

    public function esAdmin(): bool
    {
        return $this->tieneRol('Administrador');
    }

    public function tienePermiso(string $llave): bool
    {
        if ($this->esAdmin()) return true;
        return $this->rol->permisos()->where('llave', $llave)->exists();
    }
}
