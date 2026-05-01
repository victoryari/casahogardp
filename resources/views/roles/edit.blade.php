@extends('layouts.app')
@section('title','Editar Rol')
@section('page-title','Editar Rol')
@section('breadcrumb')<a href="{{ route('roles.index') }}" class="hover:text-teal-600">Roles</a> / Editar@endsection
@section('content')
<div class="max-w-md"><div class="card">
<form method="POST" action="{{ route('roles.update', $rol) }}" class="space-y-5">
    @csrf @method('PUT')
    <div><label class="form-label">Nombre del Rol *</label>
        <input type="text" name="nombre_rol" value="{{ old('nombre_rol', $rol->nombre_rol) }}" class="form-input @error('nombre_rol') is-invalid @enderror" required>
        @error('nombre_rol')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div><label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="2" class="form-textarea">{{ old('descripcion', $rol->descripcion) }}</textarea></div>
    <div><label class="form-label">Estado</label>
        <select name="estado" class="form-select max-w-xs">
            <option value="1" @selected($rol->estado==1)>Activo</option>
            <option value="0" @selected($rol->estado==0)>Inactivo</option>
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('roles.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
