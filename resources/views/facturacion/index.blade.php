@extends('layouts.app')
@section('title','Facturación')
@section('page-title','Facturación')
@section('header-actions')
<a href="{{ route('facturacion.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Nueva Factura
</a>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="filter-bar items-center">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar paciente..." class="form-input max-w-xs">
        <select name="estado" class="form-select w-36">
            <option value="">Todos</option>
            <option value="1" @selected(request('estado')==='1')>Vigente</option>
            <option value="0" @selected(request('estado')==='0')>Anulada</option>
        </select>
        <button type="submit" class="btn-primary">Buscar</button>
        <a href="{{ route('facturacion.index') }}" class="btn-secondary">Limpiar</a>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr><th>N° Factura</th><th>Paciente</th><th>Fecha</th><th>Subtotal</th><th>IGV</th><th>Total</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse($facturas as $f)
                <tr>
                    <td class="font-mono font-medium">{{ $f->serie }}-{{ $f->correlativo }}</td>
                    <td>{{ optional($f->paciente)->nombre_completo }}</td>
                    <td class="text-xs text-slate-500">{{ $f->fecha_emision->format('d/m/Y') }}</td>
                    <td>S/ {{ number_format($f->subtotal, 2) }}</td>
                    <td class="text-slate-400 text-sm">S/ {{ number_format($f->impuestos, 2) }}</td>
                    <td class="font-bold text-slate-800">S/ {{ number_format($f->total, 2) }}</td>
                    <td><span @class(['badge-active'=>$f->estado,'badge-inactive'=>!$f->estado])>{{ $f->estado?'Vigente':'Anulada' }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('facturacion.pdf', $f) }}" class="p-1.5 text-teal-600 hover:bg-teal-50 rounded-lg transition-colors" title="Descargar PDF">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                            <a href="{{ route('facturacion.show', $f) }}" class="btn-secondary py-1 px-2 text-xs">Ver</a>
                            @if($f->estado)
                            <form method="POST" action="{{ route('facturacion.destroy', $f) }}" onsubmit="return confirm('¿Anular factura?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger py-1 px-2 text-xs">Anular</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-slate-400 py-10">Sin facturas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $facturas->links() }}</div>
    </div>
</div>
@endsection
