@extends('layouts.app')
@section('title','Nuevo Rol')
@section('page-title','Crear Rol')
@section('breadcrumb')<a href="{{ route('roles.index') }}" class="hover:text-teal-600">Roles</a> / Nuevo@endsection
@section('content')
<div class="max-w-md"><div class="card">
<form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
    @csrf
    <div><label class="form-label">Nombre del Rol *</label>
        <input type="text" name="nombre_rol" value="{{ old('nombre_rol') }}" class="form-input @error('nombre_rol') is-invalid @enderror" required>
        @error('nombre_rol')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div><label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="2" class="form-textarea">{{ old('descripcion') }}</textarea></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Crear Rol</button>
        <a href="{{ route('roles.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
