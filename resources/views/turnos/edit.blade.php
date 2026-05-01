@extends('layouts.app')
@section('title','Editar Turno')
@section('page-title','Editar Turno')
@section('breadcrumb')
    <a href="{{ route('turnos.index') }}" class="hover:text-teal-600">Turnos</a> / Editar
@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('turnos.update', $turno) }}" class="space-y-5">
    @csrf @method('PUT')
    <div><label class="form-label">Personal *</label>
        <select name="id_personal" class="form-select" required>
            @foreach($personal as $p)
            <option value="{{ $p->id_personal }}" @selected(old('id_personal',$turno->id_personal)==$p->id_personal)>{{ $p->nombre_completo }}</option>
            @endforeach
        </select></div>
    <div><label class="form-label">Fecha del Turno *</label>
        <input type="date" name="fecha_turno" value="{{ old('fecha_turno', $turno->fecha_turno->format('Y-m-d')) }}" class="form-input" required></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Hora Inicio *</label>
            <input type="time" name="hora_inicio" value="{{ old('hora_inicio', $turno->hora_inicio) }}" class="form-input" required></div>
        <div><label class="form-label">Hora Fin *</label>
            <input type="time" name="hora_fin" value="{{ old('hora_fin', $turno->hora_fin) }}" class="form-input" required></div>
    </div>
    <div><label class="form-label">Estado</label>
        <select name="estado" class="form-select max-w-xs">
            <option value="1" @selected(old('estado',$turno->estado)==1)>Activo</option>
            <option value="0" @selected(old('estado',$turno->estado)==0)>Cancelado</option>
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('turnos.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
