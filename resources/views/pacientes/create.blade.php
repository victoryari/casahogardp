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
    <div class="pt-4 border-t border-slate-100">
        <p class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Información Clínica Especializada
        </p>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Alergias</label>
                <input type="text" name="alergias" value="{{ old('alergias') }}" class="form-input" placeholder="Ninguna, Penicilina, etc.">
            </div>
            <div>
                <label class="form-label">Grado de Dependencia</label>
                <select name="grado_dependencia" class="form-select">
                    <option value="Independiente">Independiente</option>
                    <option value="Leve">Dependencia Leve</option>
                    <option value="Moderada">Dependencia Moderada</option>
                    <option value="Severa">Dependencia Severa / Total</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Tipo de Dieta</label>
                <select name="tipo_dieta" class="form-select">
                    <option value="Normal">Normal</option>
                    <option value="Hiposódica">Hiposódica (Baja en sal)</option>
                    <option value="Diabética">Diabética</option>
                    <option value="Blanda">Blanda / Triturada</option>
                </select>
            </div>
            <div>
                <label class="form-label">Soporte de Movilidad</label>
                <select name="soporte_movilidad" class="form-select">
                    <option value="Ninguno">Ninguno</option>
                    <option value="Bastón">Bastón</option>
                    <option value="Andador">Andador</option>
                    <option value="Silla de Ruedas">Silla de Ruedas</option>
                    <option value="Postrado">Postrado / En cama</option>
                </select>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Medicamentos Actuales</label>
            <textarea name="medicamentos_actuales" rows="2" class="form-textarea" placeholder="Lista de fármacos y dosis...">{{ old('medicamentos_actuales') }}</textarea>
        </div>
        <div>
            <label class="form-label">Diagnóstico General / Notas</label>
            <textarea name="condicion_medica" rows="2" class="form-textarea" placeholder="Resumen de su estado al ingresar...">{{ old('condicion_medica') }}</textarea>
        </div>
    </div>

    <div class="pt-4 border-t border-slate-100">
        <p class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            Contacto de Emergencia Responsable
        </p>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nombre del Responsable</label>
                <input type="text" name="contacto_emergencia_nombre" value="{{ old('contacto_emergencia_nombre') }}" class="form-input" placeholder="Ej: Juan Pérez (Hijo)">
            </div>
            <div>
                <label class="form-label">Teléfono de Contacto</label>
                <input type="text" name="contacto_emergencia_telefono" value="{{ old('contacto_emergencia_telefono') }}" class="form-input" placeholder="999 999 999">
            </div>
        </div>
    </div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Guardar Paciente</button>
        <a href="{{ route('pacientes.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
