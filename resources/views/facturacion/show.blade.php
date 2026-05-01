@extends('layouts.app')
@section('title','Factura')
@section('page-title','Detalle de Factura')
@section('breadcrumb')
    <a href="{{ route('facturacion.index') }}" class="hover:text-teal-600">Facturación</a> / {{ $factura->serie }}-{{ $factura->correlativo }}
@endsection
@section('content')
<div class="max-w-3xl space-y-5">
    <div class="card">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-slate-400 uppercase font-semibold mb-2">Datos del Comprobante</p>
                <p class="text-2xl font-bold text-slate-800 font-mono">{{ $factura->serie }}-{{ $factura->correlativo }}</p>
                <p class="text-slate-500 text-sm mt-1">Emitida: {{ $factura->fecha_emision->format('d/m/Y H:i') }}</p>
                <p class="mt-2"><span @class(['badge-active'=>$factura->estado,'badge-inactive'=>!$factura->estado])>{{ $factura->estado?'Vigente':'Anulada' }}</span></p>
            </div>
            <div>
                <p class="text-xs text-slate-400 uppercase font-semibold mb-2">Paciente</p>
                <p class="font-semibold text-slate-800">{{ optional($factura->paciente)->nombre_completo }}</p>
                <p class="text-slate-500 text-sm">{{ optional($factura->paciente)->tipo_documento }}: {{ optional($factura->paciente)->numero_documento }}</p>
                <p class="text-xs text-slate-400 mt-2">Registrado por: {{ optional($factura->usuarioRegistro)->nombre_usuario }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <p class="font-semibold text-slate-800 mb-4">Detalle de Servicios</p>
        <div class="table-container">
            <table class="table">
                <thead><tr><th>Servicio</th><th class="text-center">Cantidad</th><th class="text-right">P. Unit.</th><th class="text-right">Subtotal</th></tr></thead>
                <tbody>
                @foreach($factura->detalles as $d)
                <tr>
                    <td class="font-medium">{{ optional($d->servicio)->nombre_servicio }}</td>
                    <td class="text-center">{{ $d->cantidad }}</td>
                    <td class="text-right">S/ {{ number_format($d->precio_unitario, 2) }}</td>
                    <td class="text-right font-semibold">S/ {{ number_format($d->subtotal, 2) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 text-sm space-y-1.5 text-right">
            <p class="text-slate-500">Subtotal: <span class="font-medium text-slate-700 ml-4">S/ {{ number_format($factura->subtotal, 2) }}</span></p>
            <p class="text-slate-500">IGV (18%): <span class="font-medium text-slate-700 ml-4">S/ {{ number_format($factura->impuestos, 2) }}</span></p>
            <p class="text-lg font-bold text-slate-800">Total: <span class="text-teal-700 ml-4">S/ {{ number_format($factura->total, 2) }}</span></p>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('facturacion.index') }}" class="btn-secondary">← Volver</a>
        <a href="{{ route('facturacion.pdf', $factura) }}" class="btn-primary !bg-slate-800 hover:!bg-slate-900 border-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Descargar PDF
        </a>
        @if($factura->estado)
        <form method="POST" action="{{ route('facturacion.destroy', $factura) }}" onsubmit="return confirm('¿Anular esta factura?')">
            @csrf @method('DELETE')
            <button class="btn-danger">Anular Factura</button>
        </form>
        @endif
    </div>
</div>
@endsection
