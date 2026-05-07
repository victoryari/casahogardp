@extends('layouts.app')
@section('title', 'Nueva Prescripción')
@section('page-title', 'Prescribir Medicación')
@section('breadcrumb')
    <a href="{{ route('pacientes.index') }}" class="hover:text-teal-600">Pacientes</a> / 
    <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="hover:text-teal-600">{{ $paciente->nombre_completo }}</a> / Prescribir
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86 7.717l.644 2.576a2 2 0 002.186 1.508l2.736-.342a2 2 0 001.21-.602l2.104-2.104a2 2 0 00.596-1.414l-.372-3.722z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 8a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Orden Médica para {{ $paciente->nombre_completo }}</h3>
                <p class="text-sm text-slate-500">Al guardar, se generará el cronograma de dosis automáticamente.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('medication.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="id_paciente" value="{{ $paciente->id_paciente }}">

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="form-label">Medicamento <span class="text-red-400">*</span></label>
                    <input type="text" name="medicamento" class="form-input" placeholder="Ej: Paracetamol, Omeprazol..." required>
                </div>
                
                <div>
                    <label class="form-label">Dosis <span class="text-red-400">*</span></label>
                    <input type="text" name="dosis" class="form-input" placeholder="Ej: 500mg, 1 tableta, 5ml" required>
                </div>

                <div>
                    <label class="form-label">Frecuencia (Horas) <span class="text-red-400">*</span></label>
                    <select name="frecuencia_horas" class="form-select" required>
                        <option value="4">Cada 4 horas</option>
                        <option value="6">Cada 6 horas</option>
                        <option value="8" selected>Cada 8 horas</option>
                        <option value="12">Cada 12 horas</option>
                        <option value="24">Cada 24 horas (Una vez al día)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Vía de Administración <span class="text-red-400">*</span></label>
                    <select name="via_administracion" class="form-select" required>
                        <option value="Oral">Oral</option>
                        <option value="Intravenosa">Intravenosa</option>
                        <option value="Intramuscular">Intramuscular</option>
                        <option value="Subcutánea">Subcutánea</option>
                        <option value="Tópica">Tópica</option>
                        <option value="Oftálmica">Oftálmica</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Fecha de Inicio <span class="text-red-400">*</span></label>
                    <input type="datetime-local" name="fecha_inicio" value="{{ date('Y-m-d\TH:i') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Fecha de Fin (Opcional)</label>
                    <input type="datetime-local" name="fecha_fin" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Indicaciones Especiales</label>
                <textarea name="indicaciones" rows="3" class="form-textarea" placeholder="Ej: Tomar después de los alimentos, no triturar la tableta..."></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Guardar y Generar Cronograma</button>
                <a href="{{ route('pacientes.show', $paciente->id_paciente) }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
