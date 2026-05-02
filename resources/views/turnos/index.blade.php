@extends('layouts.app')
@section('title','Turnos')
@section('page-title','Asignación de Turnos')
@section('header-actions')
<a href="{{ route('turnos.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Asignar Turno
</a>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="flex flex-wrap items-end gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex-1 min-w-[200px]">
            <label class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Buscar Personal</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o apellido..." class="form-input">
        </div>
        <div>
            <label class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Filtrar por Fecha</label>
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-input">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Buscar
            </button>
            <a href="{{ route('turnos.index') }}" class="btn-secondary">Limpiar</a>
        </div>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr>
                    <th>Personal</th><th>Fecha</th><th>Hora Inicio</th><th>Hora Fin</th>
                    <th>Asignado por</th><th>Estado</th><th class="text-right">Acciones</th>
                </tr></thead>
                <tbody>
                @forelse($turnos as $t)
                <tr>
                    <td class="font-medium">{{ optional($t->personal)->nombre_completo }}</td>
                    <td>{{ $t->fecha_turno->format('d/m/Y') }}</td>
                    <td>{{ $t->hora_inicio }}</td>
                    <td>{{ $t->hora_fin }}</td>
                    <td class="text-slate-500 text-sm">{{ optional($t->usuarioAsigno)->nombre_usuario }}</td>
                    <td><span @class(['badge-active'=>$t->estado,'badge-inactive'=>!$t->estado])>{{ $t->estado?'Activo':'Cancelado' }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('turnos.edit', $t) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                            <form method="POST" action="{{ route('turnos.destroy', $t) }}" onsubmit="return confirm('¿Cancelar turno?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger py-1 px-2 text-xs">Cancelar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-slate-400 py-10">Sin turnos en este período.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $turnos->links() }}</div>
    </div>
</div>
@endsection
