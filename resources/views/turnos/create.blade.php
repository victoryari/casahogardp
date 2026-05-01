@extends('layouts.app')
@section('title','Asignar Turno')
@section('page-title','Asignar Turno')
@section('breadcrumb')
    <a href="{{ route('turnos.index') }}" class="hover:text-teal-600">Turnos</a> / Nuevo
@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('turnos.store') }}" class="space-y-5">
    @csrf
    <div><label class="form-label">Personal <span class="text-red-400">*</span></label>
        <select name="id_personal" class="form-select" required>
            <option value="">Seleccionar...</option>
            @foreach($personal as $p)
            <option value="{{ $p->id_personal }}" @selected(old('id_personal')==$p->id_personal)>{{ $p->nombre_completo }} – {{ $p->cargo }}</option>
            @endforeach
        </select>
        @error('id_personal')<p class="form-error">{{ $message }}</p>@enderror</div>
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
        <button type="submit" class="btn-primary">Asignar Turno</button>
        <a href="{{ route('turnos.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
