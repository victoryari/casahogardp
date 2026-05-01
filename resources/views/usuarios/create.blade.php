@extends('layouts.app')
@section('title','Nuevo Usuario')
@section('page-title','Crear Usuario')
@section('breadcrumb')<a href="{{ route('usuarios.index') }}" class="hover:text-teal-600">Usuarios</a> / Nuevo@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('usuarios.store') }}" class="space-y-5">
    @csrf
    <div><label class="form-label">Nombre de Usuario *</label>
        <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario') }}" class="form-input @error('nombre_usuario') is-invalid @enderror" required autocomplete="off">
        @error('nombre_usuario')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Contraseña *</label>
            <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" required autocomplete="new-password">
            @error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Confirmar Contraseña *</label>
            <input type="password" name="password_confirmation" class="form-input" required></div>
    </div>
    <div><label class="form-label">Rol *</label>
        <select name="id_rol" class="form-select" required>
            <option value="">Seleccionar rol...</option>
            @foreach($roles as $r)
            <option value="{{ $r->id_rol }}" @selected(old('id_rol')==$r->id_rol)>{{ $r->nombre_rol }}</option>
            @endforeach
        </select>
        @error('id_rol')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div><label class="form-label">Vincular a Personal <span class="text-slate-400 text-xs">(opcional)</span></label>
        <select name="id_personal" class="form-select">
            <option value="">Sin vinculación</option>
            @foreach($personal as $p)
            <option value="{{ $p->id_personal }}" @selected(old('id_personal')==$p->id_personal)>{{ $p->nombre_completo }}</option>
            @endforeach
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Crear Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
