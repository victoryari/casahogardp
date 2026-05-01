@extends('layouts.app')
@section('title','Servicios')
@section('page-title','Catálogo de Servicios')
@section('header-actions')
<a href="{{ route('servicios.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Nuevo Servicio
</a>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="filter-bar items-center">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar servicio..." class="form-input max-w-xs">
        <button type="submit" class="btn-primary">Buscar</button>
        <a href="{{ route('servicios.index') }}" class="btn-secondary">Limpiar</a>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr><th>Código</th><th>Nombre</th><th>Descripción</th><th>Precio Ref.</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse($servicios as $s)
                <tr>
                    <td class="font-mono text-xs text-slate-500">{{ $s->codigo_servicio ?? '—' }}</td>
                    <td class="font-medium">{{ $s->nombre_servicio }}</td>
                    <td class="text-slate-500 text-sm max-w-xs truncate">{{ $s->descripcion ?? '—' }}</td>
                    <td class="font-semibold text-teal-600">S/ {{ number_format($s->precio_referencial, 2) }}</td>
                    <td><span @class(['badge-active'=>$s->estado,'badge-inactive'=>!$s->estado])>{{ $s->estado?'Activo':'Inactivo' }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('servicios.edit', $s) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                            <form method="POST" action="{{ route('servicios.destroy', $s) }}" onsubmit="return confirm('¿Desactivar?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger py-1 px-2 text-xs">Desactivar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-slate-400 py-10">Sin servicios registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $servicios->links() }}</div>
    </div>
</div>
@endsection
