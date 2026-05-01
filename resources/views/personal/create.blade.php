@extends('layouts.app')
@section('title', 'Nuevo Personal')
@section('page-title', 'Registrar Personal')
@section('breadcrumb') <a href="{{ route('personal.index') }}" class="hover:text-teal-600">Personal</a> / Nuevo @endsection

@section('content')
<div class="max-w-2xl">
<div class="card">
    <form method="POST" action="{{ route('personal.store') }}" class="space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nombres <span class="text-red-400">*</span></label>
                <input type="text" name="nombres" value="{{ old('nombres') }}" class="form-input @error('nombres') is-invalid @enderror" required>
                @error('nombres')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Apellidos <span class="text-red-400">*</span></label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-input @error('apellidos') is-invalid @enderror" required>
                @error('apellidos')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Tipo Documento <span class="text-red-400">*</span></label>
                <select name="tipo_documento" class="form-select">
                    <option value="DNI"  @selected(old('tipo_documento','DNI')==='DNI')>DNI</option>
                    <option value="CE"   @selected(old('tipo_documento')==='CE')>Carnet Extranjeía</option>
                    <option value="Pasaporte" @selected(old('tipo_documento')==='Pasaporte')>Pasaporte</option>
                </select>
            </div>
            <div>
                <label class="form-label">N° Documento <span class="text-red-400">*</span></label>
                <input type="text" name="numero_documento" value="{{ old('numero_documento') }}" class="form-input @error('numero_documento') is-invalid @enderror" required>
                @error('numero_documento')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Cargo <span class="text-red-400">*</span></label>
                <input type="text" name="cargo" value="{{ old('cargo') }}" class="form-input @error('cargo') is-invalid @enderror" required>
                @error('cargo')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Modalidad de Contrato <span class="text-red-400">*</span></label>
                <select name="modalidad_contrato" class="form-select">
                    @foreach(['Planilla','Recibo por Honorarios','Locación de Servicios','Practicante'] as $m)
                    <option value="{{ $m }}" @selected(old('modalidad_contrato')===$m)>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-input max-w-xs">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Guardar Personal</button>
            <a href="{{ route('personal.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</div>
@endsection
