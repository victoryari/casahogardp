@extends('layouts.app')
@section('title','Editar Paciente')
@section('page-title','Editar Paciente')
@section('breadcrumb')<a href="{{ route('pacientes.index') }}" class="hover:text-teal-600">Pacientes</a> / Editar@endsection
@section('content')
<div class="max-w-2xl"><div class="card">
<form method="POST" action="{{ route('pacientes.update', $paciente) }}" class="space-y-5">
    @csrf @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Nombres *</label>
            <input type="text" name="nombres" value="{{ old('nombres', $paciente->nombres) }}" class="form-input" required></div>
        <div><label class="form-label">Apellidos *</label>
            <input type="text" name="apellidos" value="{{ old('apellidos', $paciente->apellidos) }}" class="form-input" required></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Tipo Documento</label>
            <select name="tipo_documento" class="form-select">
                @foreach(['DNI','CE','Pasaporte'] as $t)
                <option value="{{ $t }}" @selected(old('tipo_documento',$paciente->tipo_documento)===$t)>{{ $t }}</option>
                @endforeach
            </select></div>
        <div><label class="form-label">N° Documento *</label>
            <input type="text" name="numero_documento" value="{{ old('numero_documento', $paciente->numero_documento) }}" class="form-input" required>
            @error('numero_documento')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Fecha Nacimiento *</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}" class="form-input" required></div>
        <div><label class="form-label">Fecha Ingreso *</label>
            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $paciente->fecha_ingreso->format('Y-m-d')) }}" class="form-input" required></div>
    </div>
    <div class="pt-4 border-t border-slate-100">
        <p class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Información Clínica Especializada
        </p>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Alergias</label>
                <input type="text" name="alergias" value="{{ old('alergias', $paciente->alergias) }}" class="form-input" placeholder="Ninguna, Penicilina, etc.">
            </div>
            <div>
                <label class="form-label">Grado de Dependencia</label>
                <select name="grado_dependencia" class="form-select">
                    @foreach(['Independiente', 'Leve', 'Moderada', 'Severa'] as $g)
                    <option value="{{ $g }}" @selected(old('grado_dependencia', $paciente->grado_dependencia) === $g)>{{ $g === 'Severa' ? 'Dependencia Severa / Total' : ($g === 'Leve' ? 'Dependencia Leve' : ($g === 'Moderada' ? 'Dependencia Moderada' : $g)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Tipo de Dieta</label>
                <select name="tipo_dieta" class="form-select">
                    @foreach(['Normal', 'Hiposódica', 'Diabética', 'Blanda'] as $d)
                    <option value="{{ $d }}" @selected(old('tipo_dieta', $paciente->tipo_dieta) === $d)>{{ $d === 'Hiposódica' ? 'Hiposódica (Baja en sal)' : ($d === 'Blanda' ? 'Blanda / Triturada' : $d) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Soporte de Movilidad</label>
                <select name="soporte_movilidad" class="form-select">
                    @foreach(['Ninguno', 'Bastón', 'Andador', 'Silla de Ruedas', 'Postrado'] as $s)
                    <option value="{{ $s }}" @selected(old('soporte_movilidad', $paciente->soporte_movilidad) === $s)>{{ $s === 'Silla de Ruedas' ? 'Silla de Ruedas' : ($s === 'Postrado' ? 'Postrado / En cama' : $s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Medicamentos Actuales</label>
            <textarea name="medicamentos_actuales" rows="2" class="form-textarea" placeholder="Lista de fármacos y dosis...">{{ old('medicamentos_actuales', $paciente->medicamentos_actuales) }}</textarea>
        </div>
        <div>
            <label class="form-label">Diagnóstico General / Notas</label>
            <textarea name="condicion_medica" rows="2" class="form-textarea" placeholder="Resumen de su estado al ingresar...">{{ old('condicion_medica', $paciente->condicion_medica) }}</textarea>
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
                <input type="text" name="contacto_emergencia_nombre" value="{{ old('contacto_emergencia_nombre', $paciente->contacto_emergencia_nombre) }}" class="form-input" placeholder="Ej: Juan Pérez (Hijo)">
            </div>
            <div>
                <label class="form-label">Teléfono de Contacto</label>
                <input type="text" name="contacto_emergencia_telefono" value="{{ old('contacto_emergencia_telefono', $paciente->contacto_emergencia_telefono) }}" class="form-input" placeholder="999 999 999">
            </div>
        </div>
    </div>
    <div><label class="form-label">Estado de la Cuenta</label>
        <select name="estado" class="form-select max-w-xs">
            <option value="1" @selected(old('estado',$paciente->estado)==1)>Activo</option>
            <option value="0" @selected(old('estado',$paciente->estado)==0)>Inactivo</option>
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('pacientes.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
