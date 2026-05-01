@extends('layouts.app')
@section('title','Editar Servicio')
@section('page-title','Editar Servicio')
@section('breadcrumb')<a href="{{ route('servicios.index') }}" class="hover:text-teal-600">Servicios</a> / Editar@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('servicios.update', $servicio) }}" class="space-y-5">
    @csrf @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Código</label>
            <input type="text" name="codigo_servicio" value="{{ old('codigo_servicio', $servicio->codigo_servicio) }}" class="form-input @error('codigo_servicio') is-invalid @enderror">
            @error('codigo_servicio')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Precio (S/) *</label>
            <input type="number" step="0.01" name="precio_referencial" value="{{ old('precio_referencial', $servicio->precio_referencial) }}" class="form-input" required></div>
    </div>
    <div><label class="form-label">Nombre *</label>
        <input type="text" name="nombre_servicio" value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" class="form-input" required></div>
    <div><label class="form-label">Descripción</label>
        <textarea name="descripcion" rows="3" class="form-textarea">{{ old('descripcion', $servicio->descripcion) }}</textarea></div>
    <div><label class="form-label">Estado</label>
        <select name="estado" class="form-select max-w-xs">
            <option value="1" @selected($servicio->estado==1)>Activo</option>
            <option value="0" @selected($servicio->estado==0)>Inactivo</option>
        </select></div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Actualizar</button>
        <a href="{{ route('servicios.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
