@extends('layouts.app')
@section('title','Editar Usuario')
@section('page-title','Editar Cuenta: ' . $usuario->nombre_usuario)
@section('breadcrumb')
    <a href="{{ route('usuarios.index') }}" class="hover:text-teal-600">Usuarios</a> / Editar
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nombre de Usuario <span class="text-red-400">*</span></label>
                    <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" class="form-input @error('nombre_usuario') is-invalid @enderror" required>
                    @error('nombre_usuario') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Rol de Sistema <span class="text-red-400">*</span></label>
                    <select name="id_rol" class="form-select" required>
                        @foreach($roles as $r)
                        <option value="{{ $r->id_rol }}" @selected(old('id_rol', $usuario->id_rol) == $r->id_rol)>{{ $r->nombre_rol }}</option>
                        @endforeach
                    </select>
                    @error('id_rol') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Personal Asociado</label>
                    <select name="id_personal" class="form-select">
                        <option value="">-- No vincular --</option>
                        @foreach($personal as $p)
                        <option value="{{ $p->id_personal }}" @selected(old('id_personal', $usuario->id_personal) == $p->id_personal)>{{ $p->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Estado de la Cuenta</label>
                    <select name="estado" class="form-select">
                        <option value="1" @selected(old('estado', $usuario->estado) == 1)>Activa</option>
                        <option value="0" @selected(old('estado', $usuario->estado) == 0)>Inactiva / Bloqueada</option>
                    </select>
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                <p class="text-sm font-bold text-amber-800 mb-2">Cambiar Contraseña</p>
                <p class="text-xs text-amber-700 mb-4">Deja estos campos en blanco si no deseas cambiar la contraseña actual.</p>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-input bg-white">
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-input bg-white">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Actualizar Datos</button>
                <a href="{{ route('usuarios.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
