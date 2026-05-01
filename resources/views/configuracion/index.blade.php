@extends('layouts.app')
@section('title','Configuración')
@section('page-title','Configuración del Sistema')
@section('content')
<div class="max-w-2xl"><div class="card">
<form method="POST" action="{{ route('configuracion.update') }}" class="space-y-5">
    @csrf @method('PUT')
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">RUC *</label>
            <input type="text" name="ruc" value="{{ old('ruc', $config->ruc) }}" class="form-input" required maxlength="20">
            @error('ruc')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Moneda</label>
            <select name="moneda" class="form-select">
                <option value="PEN" @selected(old('moneda',$config->moneda)==='PEN')>PEN – Soles</option>
                <option value="USD" @selected(old('moneda',$config->moneda)==='USD')>USD – Dólares</option>
            </select></div>
    </div>
    <div><label class="form-label">Razón Social *</label>
        <input type="text" name="razon_social" value="{{ old('razon_social', $config->razon_social) }}" class="form-input" required></div>
    <div><label class="form-label">Nombre Comercial *</label>
        <input type="text" name="nombre_comercial" value="{{ old('nombre_comercial', $config->nombre_comercial) }}" class="form-input" required></div>
    <div><label class="form-label">Dirección</label>
        <input type="text" name="direccion" value="{{ old('direccion', $config->direccion) }}" class="form-input"></div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $config->telefono) }}" class="form-input"></div>
        <div><label class="form-label">Correo</label>
            <input type="email" name="correo" value="{{ old('correo', $config->correo) }}" class="form-input"></div>
    </div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Guardar Configuración</button>
    </div>
</form>
</div></div>
@endsection
