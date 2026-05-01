@extends('layouts.app')
@section('title','Nuevo Paciente')
@section('page-title','Registrar Paciente')
@section('breadcrumb')
    <a href="{{ route('pacientes.index') }}" class="hover:text-teal-600">Pacientes</a> / Nuevo
@endsection
@section('content')
<div class="max-w-2xl"><div class="card">
<form method="POST" action="{{ route('pacientes.store') }}" class="space-y-5">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Nombres <span class="text-red-400">*</span></label>
            <input type="text" name="nombres" value="{{ old('nombres') }}" class="form-input @error('nombres') is-invalid @enderror" required>
            @error('nombres')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Apellidos <span class="text-red-400">*</span></label>
            <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-input @error('apellidos') is-invalid @enderror" required>
            @error('apellidos')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Tipo Documento</label>
            <select name="tipo_documento" class="form-select">
                <option value="DNI">DNI</option><option value="CE">CE</option><option value="Pasaporte">Pasaporte</option>
            </select></div>
        <div><label class="form-label">N° Documento <span class="text-red-400">*</span></label>
            <input type="text" name="numero_documento" value="{{ old('numero_documento') }}" class="form-input @error('numero_documento') is-invalid @enderror" required>
            @error('numero_documento')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Fecha de Nacimiento <span class="text-red-400">*</span></label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="form-input" required>
            @error('fecha_nacimiento')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Fecha de Ingreso <span class="text-red-400">*</span></label>
            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', date('Y-m-d')) }}" class="form-input" required>
            @error('fecha_ingreso')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Contacto de Emergencia</label>
            <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}" class="form-input"></div>
        <div><label class="form-label">Teléfono Emergencia</label>
            <input type="text" name="telefono_emergencia" value="{{ old('telefono_emergencia') }}" class="form-input"></div>
    </div>
    <div><label class="form-label">Condición Médica / Notas</label>
        <textarea name="condicion_medica" rows="3" class="form-textarea">{{ old('condicion_medica') }}</textarea></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Guardar Paciente</button>
        <a href="{{ route('pacientes.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
