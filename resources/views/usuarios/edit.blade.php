@extends('layouts.app')
@section('title','Editar Usuario')
@section('page-title','Editar Usuario')
@section('breadcrumb')<a href="{{ route('usuarios.index') }}" class="hover:text-teal-600">Usuarios</a> / Editar@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="space-y-5">
    @csrf @method('PUT')
    <div><label class="form-label">Nombre de Usuario *</label>
        <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" class="form-input" required>
        @error('nombre_usuario')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-700">
        Deja vacío si no deseas cambiar la contraseña.
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Nueva Contraseña</label>
            <input type="password" name="password" class="form-input" autocomplete="new-password">
            @error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Confirmar</label>
            <input type="password" name="password_confirmation" class="form-input"></div>
    </div>
    <div><label class="form-label">Rol *</label>
        <select name="id_rol" class="form-select" required>
            @foreach($roles as $r)
            <option value="{{ $r->id_rol }}" @selected(old('id_rol',$usuario->id_rol)==$r->id_rol)>{{ $r->nombre_rol }}</option>
            @endforeach
        </select></div>
    <div><label class="form-label">Personal Vinculado</label>
        <select name="id_personal" class="form-select">
            <option value="">Sin vinculación</option>
            @foreach($personal as $p)
            <option value="{{ $p->id_personal }}" @selected(old('id_personal',$usuario->id_personal)==$p->id_personal)>{{ $p->nombre_completo }}</option>
            @endforeach
        </select></div>
    <div><label class="form-label">Estado</label>
        <select name="estado" class="form-select max-w-xs">
            <option value="1" @selected($usuario->estado==1)>Activo</option>
            <option value="0" @selected($usuario->estado==0)>Inactivo</option>
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
