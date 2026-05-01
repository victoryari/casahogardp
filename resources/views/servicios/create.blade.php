@extends('layouts.app')
@section('title','Nuevo Servicio')
@section('page-title','Registrar Servicio')
@section('breadcrumb')<a href="{{ route('servicios.index') }}" class="hover:text-teal-600">Servicios</a> / Nuevo@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('servicios.store') }}" class="space-y-5">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Código</label>
            <input type="text" name="codigo_servicio" value="{{ old('codigo_servicio') }}" class="form-input @error('codigo_servicio') is-invalid @enderror" placeholder="SRV-001">
            @error('codigo_servicio')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Precio Referencial (S/) *</label>
            <input type="number" step="0.01" name="precio_referencial" value="{{ old('precio_referencial',0) }}" class="form-input" required></div>
    </div>
    <div><label class="form-label">Nombre del Servicio *</label>
        <input type="text" name="nombre_servicio" value="{{ old('nombre_servicio') }}" class="form-input @error('nombre_servicio') is-invalid @enderror" required>
        @error('nombre_servicio')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div><label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="3" class="form-textarea">{{ old('descripcion') }}</textarea></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Guardar Servicio</button>
        <a href="{{ route('servicios.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
