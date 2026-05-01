@extends('layouts.app')
@section('title','Marketing')
@section('page-title','Prospectos de Marketing')
@section('header-actions')
<a href="{{ route('marketing.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Nuevo Prospecto
</a>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="filter-bar items-center">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar contacto..." class="form-input max-w-xs">
        <select name="estado_seguimiento" class="form-select w-40">
            <option value="">Todos</option>
            @foreach(['Pendiente','En Seguimiento','Convertido','Descartado'] as $e)
            <option value="{{ $e }}" @selected(request('estado_seguimiento')===$e)>{{ $e }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Buscar</button>
        <a href="{{ route('marketing.index') }}" class="btn-secondary">Limpiar</a>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr>
                    <th>Contacto</th><th>Teléfono</th><th>Correo</th><th>Medio</th>
                    <th>Seguimiento</th><th>Fecha</th><th class="text-right">Acciones</th>
                </tr></thead>
                <tbody>
                @forelse($prospectos as $p)
                <tr>
                    <td class="font-medium">{{ $p->nombre_contacto }}</td>
                    <td class="text-slate-500">{{ $p->telefono ?? '—' }}</td>
                    <td class="text-slate-500 text-xs">{{ $p->correo ?? '—' }}</td>
                    <td><span class="badge-info">{{ $p->medio_contacto }}</span></td>
                    <td>
                        <span @class([
                            'badge-pending'  => $p->estado_seguimiento==='Pendiente',
                            'badge-info'     => $p->estado_seguimiento==='En Seguimiento',
                            'badge-active'   => $p->estado_seguimiento==='Convertido',
                            'badge-inactive' => $p->estado_seguimiento==='Descartado',
                        ])>{{ $p->estado_seguimiento }}</span>
                    </td>
                    <td class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($p->fecha_registro)->format('d/m/Y') }}</td>
                    <td class="text-right">
                        <a href="{{ route('marketing.edit', $p) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-slate-400 py-10">Sin prospectos.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $prospectos->links() }}</div>
    </div>
</div>
@endsection
