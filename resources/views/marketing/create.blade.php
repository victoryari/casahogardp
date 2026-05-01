@extends('layouts.app')
@section('title','Nuevo Prospecto')
@section('page-title','Registrar Prospecto')
@section('breadcrumb')<a href="{{ route('marketing.index') }}" class="hover:text-teal-600">Marketing</a> / Nuevo@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('marketing.store') }}" class="space-y-5">
    @csrf
    <div><label class="form-label">Nombre del Contacto *</label>
        <input type="text" name="nombre_contacto" value="{{ old('nombre_contacto') }}" class="form-input" required></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-input"></div>
        <div><label class="form-label">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}" class="form-input"></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Medio de Contacto *</label>
            <select name="medio_contacto" class="form-select">
                @foreach(['Redes Sociales','Referido','Página Web','Llamada','WhatsApp','Otro'] as $m)
                <option value="{{ $m }}" @selected(old('medio_contacto')===$m)>{{ $m }}</option>
                @endforeach
            </select></div>
        <div><label class="form-label">Estado de Seguimiento *</label>
            <select name="estado_seguimiento" class="form-select">
                @foreach(['Pendiente','En Seguimiento','Convertido','Descartado'] as $e)
                <option value="{{ $e }}" @selected(old('estado_seguimiento')===$e)>{{ $e }}</option>
                @endforeach
            </select></div>
    </div>
    <div><label class="form-label">Interés Mostrado</label>
        <textarea name="interes_mostrado" rows="3" class="form-textarea">{{ old('interes_mostrado') }}</textarea></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Guardar</button>
        <a href="{{ route('marketing.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
