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
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Contacto Emergencia</label>
            <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia', $paciente->contacto_emergencia) }}" class="form-input"></div>
        <div><label class="form-label">Teléfono Emergencia</label>
            <input type="text" name="telefono_emergencia" value="{{ old('telefono_emergencia', $paciente->telefono_emergencia) }}" class="form-input"></div>
    </div>
    <div><label class="form-label">Condición Médica</label>
        <textarea name="condicion_medica" rows="3" class="form-textarea">{{ old('condicion_medica', $paciente->condicion_medica) }}</textarea></div>
    <div><label class="form-label">Estado</label>
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
