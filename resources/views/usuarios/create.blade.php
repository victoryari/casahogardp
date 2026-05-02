@extends('layouts.app')
@section('title','Nuevo Usuario')
@section('page-title','Crear Cuenta de Usuario')
@section('breadcrumb')
    <a href="{{ route('usuarios.index') }}" class="hover:text-teal-600">Usuarios</a> / Nuevo
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nombre de Usuario <span class="text-red-400">*</span></label>
                    <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario') }}" class="form-input @error('nombre_usuario') is-invalid @enderror" placeholder="ej: jlopez" required>
                    @error('nombre_usuario') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Rol de Sistema <span class="text-red-400">*</span></label>
                    <select name="id_rol" class="form-select" required>
                        <option value="">Seleccionar rol...</option>
                        @foreach($roles as $r)
                        <option value="{{ $r->id_rol }}" @selected(old('id_rol') == $r->id_rol)>{{ $r->nombre_rol }}</option>
                        @endforeach
                    </select>
                    @error('id_rol') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Vincular con Personal (Opcional)</label>
                <select name="id_personal" class="form-select">
                    <option value="">-- No vincular --</option>
                    @foreach($personal as $p)
                    <option value="{{ $p->id_personal }}" @selected(old('id_personal') == $p->id_personal)>{{ $p->nombre_completo }} ({{ $p->cargo }})</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-1 italic">Solo se muestran empleados que aún no tienen una cuenta de usuario.</p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Confirmar Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Crear Usuario</button>
                <a href="{{ route('usuarios.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
