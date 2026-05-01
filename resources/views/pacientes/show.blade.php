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
        @if($paciente->contacto_emergencia)
        <div class="pt-3 border-t border-slate-100">
            <p class="text-xs text-slate-400 font-medium uppercase mb-1">Contacto Emergencia</p>
            <p class="text-sm font-medium text-slate-700">{{ $paciente->contacto_emergencia }}</p>
            <p class="text-sm text-slate-500">{{ $paciente->telefono_emergencia }}</p>
        </div>
        @endif
        @if($paciente->condicion_medica)
        <div class="pt-3 border-t border-slate-100">
            <p class="text-xs text-slate-400 font-medium uppercase mb-1">Condición Médica</p>
            <p class="text-sm text-slate-700">{{ $paciente->condicion_medica }}</p>
        </div>
        @endif
    </div>
    <div class="lg:col-span-2 space-y-4">
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
