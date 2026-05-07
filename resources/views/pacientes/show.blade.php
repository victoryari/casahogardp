@extends('layouts.app')
@section('title','Detalle Paciente')
@section('page-title','Ficha del Paciente')
@section('breadcrumb')<a href="{{ route('pacientes.index') }}" class="hover:text-teal-600">Pacientes</a> / {{ $paciente->nombre_completo }}@endsection
@section('header-actions')
<a href="{{ route('pacientes.edit', $paciente) }}" class="btn-primary">Editar</a>
@endsection
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card lg:col-span-1 space-y-4">
        <div class="text-center pb-4 border-b border-slate-100">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-blue-600 text-2xl font-bold">{{ strtoupper(substr($paciente->nombres,0,1)) }}</span>
            </div>
            <h2 class="font-bold text-slate-800 text-lg">{{ $paciente->nombre_completo }}</h2>
            <p class="text-slate-400 text-sm">{{ $paciente->tipo_documento }}: {{ $paciente->numero_documento }}</p>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-slate-500">Edad</span><span class="font-medium">{{ $paciente->edad }} años</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Nacimiento</span><span class="font-medium">{{ $paciente->fecha_nacimiento->format('d/m/Y') }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Ingreso</span><span class="font-medium">{{ $paciente->fecha_ingreso->format('d/m/Y') }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Estado</span>
                <span @class(['badge-active'=>$paciente->estado,'badge-inactive'=>!$paciente->estado])>{{ $paciente->estado?'Activo':'Inactivo' }}</span></div>
        </div>
        @if($paciente->contacto_emergencia_nombre)
        <div class="pt-3 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 font-bold uppercase mb-2">Responsable / Emergencia</p>
            <div class="bg-red-50/50 p-3 rounded-xl border border-red-100/50">
                <p class="text-sm font-bold text-red-800">{{ $paciente->contacto_emergencia_nombre }}</p>
                <p class="text-sm text-red-600 flex items-center gap-2 mt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $paciente->contacto_emergencia_telefono }}
                </p>
            </div>
        </div>
        @endif
    </div>
    <div class="lg:col-span-2 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="card bg-teal-50/30 border-teal-100/50">
                <h3 class="text-xs font-bold text-teal-800 uppercase mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.603 3.303l-2.408 2.41a3.323 3.323 0 000 4.699 3.323 3.323 0 004.699 0l2.408-2.41a3.323 3.323 0 000-4.699zM12 14a3 3 0 110-6 3 3 0 010 6z"/></svg>
                    Perfil de Salud
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold">Alergias</p>
                        <p class="text-sm font-medium {{ $paciente->alergias ? 'text-red-600' : 'text-slate-600' }}">{{ $paciente->alergias ?: 'Ninguna registrada' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Dependencia</p>
                            <p class="text-sm font-medium text-slate-700">{{ $paciente->grado_dependencia ?: 'No definido' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Movilidad</p>
                            <p class="text-sm font-medium text-slate-700">{{ $paciente->soporte_movilidad ?: 'No definido' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-orange-50/30 border-orange-100/50">
                <h3 class="text-xs font-bold text-orange-800 uppercase mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Dieta y Medicación
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold">Tipo de Dieta</p>
                        <p class="text-sm font-medium text-slate-700">{{ $paciente->tipo_dieta ?: 'No definido' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold">Medicamentos</p>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $paciente->medicamentos_actuales ?: 'Sin medicación registrada' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h3 class="text-xs font-bold text-slate-400 uppercase mb-3">Diagnóstico y Notas Adicionales</h3>
            <p class="text-sm text-slate-700 leading-relaxed">{{ $paciente->condicion_medica ?: 'Sin notas adicionales.' }}</p>
        </div>
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-slate-800">Medicación Activa (Kardex)</h3>
                <a href="{{ route('medication.create', $paciente) }}" class="text-teal-600 text-xs font-bold uppercase hover:underline flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Prescripción
                </a>
            </div>
            @if($paciente->prescripciones->where('estado', 'activa')->isEmpty())
                <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-6 text-center">
                    <p class="text-slate-400 text-sm">No hay medicamentos activos registrados en el sistema.</p>
                </div>
            @else
            <div class="table-container">
                <table class="table">
                    <thead><tr><th>Medicamento</th><th>Dosis</th><th>Frecuencia</th><th>Vía</th><th>Inicio</th></tr></thead>
                    <tbody>
                    @foreach($paciente->prescripciones->where('estado', 'activa') as $p)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $p->medicamento }}</td>
                        <td class="text-xs text-slate-500">{{ $p->dosis }}</td>
                        <td>Cada {{ $p->frecuencia_horas }}h</td>
                        <td><span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase">{{ $p->via_administracion }}</span></td>
                        <td class="text-xs text-slate-500">{{ $p->fecha_inicio->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div class="card">
            <h3 class="font-semibold text-slate-800 mb-4">Historial de Facturas</h3>
            @if($paciente->facturas->isEmpty())
                <p class="text-slate-400 text-sm">Sin facturas registradas.</p>
            @else
            <div class="table-container">
                <table class="table">
                    <thead><tr><th>Nro</th><th>Fecha</th><th>Subtotal</th><th>IGV</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                    @foreach($paciente->facturas as $f)
                    <tr>
                        <td><a href="{{ route('facturacion.show', $f) }}" class="text-teal-600 font-medium hover:underline">{{ $f->serie }}-{{ $f->correlativo }}</a></td>
                        <td class="text-xs text-slate-500">{{ $f->fecha_emision->format('d/m/Y') }}</td>
                        <td>S/ {{ number_format($f->subtotal, 2) }}</td>
                        <td>S/ {{ number_format($f->impuestos, 2) }}</td>
                        <td class="font-semibold">S/ {{ number_format($f->total, 2) }}</td>
                        <td><span @class(['badge-active'=>$f->estado,'badge-inactive'=>!$f->estado])>{{ $f->estado?'Vigente':'Anulada' }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
