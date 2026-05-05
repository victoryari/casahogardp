@extends('layouts.app')
@section('title','Editar Rol')
@section('page-title','Editar Rol: ' . $rol->nombre_rol)
@section('breadcrumb')
    <a href="{{ route('roles.index') }}" class="hover:text-teal-600">Roles</a> / Editar
@endsection

@section('content')
<div class="max-w-3xl">
    <div class="card">
        <form action="{{ route('roles.update', $rol) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="form-label">Nombre del Rol <span class="text-red-400">*</span></label>
                <input type="text" name="nombre_rol" value="{{ old('nombre_rol', $rol->nombre_rol) }}" class="form-input @error('nombre_rol') is-invalid @enderror" required>
                @error('nombre_rol') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" rows="3" class="form-textarea">{{ old('descripcion', $rol->descripcion) }}</textarea>
                @error('descripcion') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Estado del Rol</label>
                <select name="estado" class="form-select max-w-xs">
                    <option value="1" @selected(old('estado', $rol->estado) == 1)>Activo</option>
                    <option value="0" @selected(old('estado', $rol->estado) == 0)>Inactivo</option>
                </select>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <p class="text-sm font-bold text-slate-800 mb-4">Permisos del Sistema</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($permisos as $modulo => $lista)
                    <div class="space-y-3">
                        <p class="text-[10px] font-bold text-teal-600 uppercase tracking-widest">{{ $modulo }}</p>
                        <div class="space-y-2">
                            @foreach($lista as $p)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="permisos[]" value="{{ $p->id_permiso }}" 
                                        @checked(in_array($p->id_permiso, $rolPermisos))
                                        class="w-5 h-5 rounded-lg border-slate-200 text-teal-600 focus:ring-teal-500 transition-all">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-700 group-hover:text-teal-700 transition-colors">{{ $p->nombre_permiso }}</span>
                                    <span class="text-[10px] text-slate-400 leading-tight">{{ $p->descripcion ?? 'Acceso al módulo de ' . $modulo }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Actualizar Rol</button>
                <a href="{{ route('roles.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
