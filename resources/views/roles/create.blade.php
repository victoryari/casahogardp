@extends('layouts.app')
@section('title','Nuevo Rol')
@section('page-title','Crear Nuevo Rol')
@section('breadcrumb')
    <a href="{{ route('roles.index') }}" class="hover:text-teal-600">Roles</a> / Nuevo
@endsection

@section('content')
<div class="max-w-xl">
    <div class="card">
        <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="form-label">Nombre del Rol <span class="text-red-400">*</span></label>
                <input type="text" name="nombre_rol" value="{{ old('nombre_rol') }}" class="form-input @error('nombre_rol') is-invalid @enderror" placeholder="Ej: Administrador, Enfermería, etc." required>
                @error('nombre_rol') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" rows="3" class="form-textarea" placeholder="Breve descripción de las responsabilidades del rol...">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Guardar Rol</button>
                <a href="{{ route('roles.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
