@extends('layouts.app')
@section('title','Asignar Turno')
@section('page-title', (auth()->user()->esAdmin() || auth()->user()->tienePermiso('turnos.gestionar')) ? 'Asignar Turno' : 'Proponer Mi Turno')
@section('breadcrumb')
    <a href="{{ route('turnos.index') }}" class="hover:text-teal-600">Turnos</a> / {{ (auth()->user()->esAdmin() || auth()->user()->tienePermiso('turnos.gestionar')) ? 'Nuevo' : 'Propuesta' }}
@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('turnos.store') }}" class="space-y-5">
    @csrf
    @if(auth()->user()->esAdmin() || auth()->user()->tienePermiso('turnos.gestionar'))
    <div><label class="form-label">Personal <span class="text-red-400">*</span></label>
        <select name="id_personal" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($personal as $p)
            <option value="{{ $p->id_personal }}" @selected(old('id_personal')==$p->id_personal)>{{ $p->nombre_completo }} – {{ $p->cargo }}</option>
            @endforeach
        </select>
        @error('id_personal')<p class="form-error">{{ $message }}</p>@enderror</div>
    @else
    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
        <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Personal</p>
        <p class="text-sm font-bold text-slate-700">{{ optional(auth()->user()->personal)->nombre_completo ?? auth()->user()->nombre_usuario }}</p>
        <p class="text-[10px] text-teal-600 font-bold uppercase mt-1">Modo: Auto-propuesta de disponibilidad</p>
    </div>
    @endif
    <div><label class="form-label">Fecha del Turno <span class="text-red-400">*</span></label>
        <input type="date" name="fecha_turno" value="{{ old('fecha_turno', date('Y-m-d')) }}" class="form-input" required>
        @error('fecha_turno')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Hora Inicio <span class="text-red-400">*</span></label>
            <input type="time" name="hora_inicio" value="{{ old('hora_inicio','07:00') }}" class="form-input" required>
            @error('hora_inicio')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Hora Fin <span class="text-red-400">*</span></label>
            <input type="time" name="hora_fin" value="{{ old('hora_fin','15:00') }}" class="form-input" required>
            @error('hora_fin')<p class="form-error">{{ $message }}</p>@enderror</div>
    </div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">
            {{ (auth()->user()->esAdmin() || auth()->user()->tienePermiso('turnos.gestionar')) ? 'Asignar Turno' : 'Enviar Propuesta' }}
        </button>
        <a href="{{ route('turnos.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
