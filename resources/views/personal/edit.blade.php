@extends('layouts.app')
@section('title', 'Editar Personal')
@section('page-title', 'Editar Personal')
@section('breadcrumb') <a href="{{ route('personal.index') }}" class="hover:text-teal-600">Personal</a> / Editar @endsection

@section('content')
<div class="max-w-2xl">
<div class="card">
    <form method="POST" action="{{ route('personal.update', $personal) }}" class="space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Nombres <span class="text-red-400">*</span></label>
                <input type="text" name="nombres" value="{{ old('nombres', $personal->nombres) }}" class="form-input @error('nombres') is-invalid @enderror" required>
                @error('nombres')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Apellidos <span class="text-red-400">*</span></label>
                <input type="text" name="apellidos" value="{{ old('apellidos', $personal->apellidos) }}" class="form-input @error('apellidos') is-invalid @enderror" required>
                @error('apellidos')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Tipo Documento</label>
                <select name="tipo_documento" class="form-select">
                    @foreach(['DNI','CE','Pasaporte'] as $t)
                    <option value="{{ $t }}" @selected(old('tipo_documento',$personal->tipo_documento)===$t)>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">N° Documento <span class="text-red-400">*</span></label>
                <input type="text" name="numero_documento" value="{{ old('numero_documento', $personal->numero_documento) }}" class="form-input @error('numero_documento') is-invalid @enderror" required>
                @error('numero_documento')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Cargo <span class="text-red-400">*</span></label>
                <input type="text" name="cargo" value="{{ old('cargo', $personal->cargo) }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Modalidad de Contrato</label>
                <select name="modalidad_contrato" class="form-select">
                    @foreach(['Planilla','Recibo por Honorarios','Locación de Servicios','Practicante'] as $m)
                    <option value="{{ $m }}" @selected(old('modalidad_contrato',$personal->modalidad_contrato)===$m)>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono', $personal->telefono) }}" class="form-input">
            </div>
            <div>
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="1" @selected(old('estado', $personal->estado)==1)>Activo</option>
                    <option value="0" @selected(old('estado', $personal->estado)==0)>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Actualizar</button>
            <a href="{{ route('personal.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</div>
@endsection
