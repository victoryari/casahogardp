@extends('layouts.app')
@section('title','Turnos')
@section('page-title','Asignación de Turnos')
@section('header-actions')
<div class="flex gap-2">
    <a href="{{ route('turnos.calendario') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Ver Calendario
    </a>
    <a href="{{ route('turnos.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ auth()->user()->esAdmin() || auth()->user()->tienePermiso('turnos.gestionar') ? 'Asignar Turno' : 'Proponer Turno' }}
    </a>
</div>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="filter-bar">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." class="form-input">
        </div>
        <div>
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-input">
        </div>
        <div>
            <select name="estado_aprobacion" class="form-select">
                <option value="">Todos los estados</option>
                <option value="pendiente" @selected(request('estado_aprobacion')==='pendiente')>Pendientes</option>
                <option value="aprobado" @selected(request('estado_aprobacion')==='aprobado')>Aprobados</option>
                <option value="rechazado" @selected(request('estado_aprobacion')==='rechazado')>Rechazados</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-primary">Buscar</button>
            <a href="{{ route('turnos.index') }}" class="btn-secondary">Limpiar</a>
        </div>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr>
                    <th>Personal</th><th>Fecha</th><th>Horario</th>
                    <th>Validación</th><th>Asignado por</th><th class="text-right">Acciones</th>
                </tr></thead>
                <tbody>
                @forelse($turnos as $t)
                <tr>
                    <td>
                        <p class="font-bold text-slate-800">{{ optional($t->personal)->nombre_completo }}</p>
                        <p class="text-[10px] text-slate-400 uppercase">{{ optional($t->personal)->cargo ?? 'Personal' }}</p>
                    </td>
                    <td>
                        <p class="text-sm font-medium">{{ $t->fecha_turno->format('d/m/Y') }}</p>
                        <p class="text-[10px] text-slate-400">{{ $t->fecha_turno->locale('es')->isoFormat('dddd') }}</p>
                    </td>
                    <td>
                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">{{ $t->hora_inicio }} - {{ $t->hora_fin }}</span>
                    </td>
                    <td>
                        @php
                            $badgeClass = match($t->estado_aprobacion) {
                                'aprobado' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'rechazado' => 'bg-red-50 text-red-600 border-red-100',
                                default => 'bg-amber-50 text-amber-600 border-amber-100',
                            };
                        @endphp
                        <span class="text-[10px] font-bold uppercase px-2 py-1 rounded-full border {{ $badgeClass }}">
                            {{ $t->estado_aprobacion }}
                        </span>
                        @if($t->estado_aprobacion === 'aprobado' && $t->usuarioValida)
                            <p class="text-[9px] text-slate-400 mt-1">Por: {{ $t->usuarioValida->nombre_usuario }}</p>
                        @endif
                    </td>
                    <td class="text-slate-500 text-xs italic">{{ optional($t->usuarioAsigno)->nombre_usuario }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Botones de Aprobación para Supervisores/Admin --}}
                            @if($canManage && $t->estado_aprobacion === 'pendiente')
                                <form method="POST" action="{{ route('turnos.validar', $t) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="accion" value="aprobado">
                                    <button class="btn-primary py-1 px-3 text-[10px] bg-emerald-600 hover:bg-emerald-700">Aprobar</button>
                                </form>
                                <form method="POST" action="{{ route('turnos.validar', $t) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="accion" value="rechazado">
                                    <button class="btn-secondary py-1 px-3 text-[10px] text-red-600 border-red-200">Rechazar</button>
                                </form>
                            @endif

                            {{-- Acciones normales --}}
                            @if($canManage || ($t->id_personal === auth()->user()->id_personal && $t->estado_aprobacion === 'pendiente'))
                                <a href="{{ route('turnos.edit', $t) }}" class="p-1.5 text-slate-400 hover:text-teal-600 transition-colors" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('turnos.destroy', $t) }}" onsubmit="return confirm('¿Cancelar este turno?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 text-slate-400 hover:text-red-600 transition-colors" title="Cancelar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-slate-400 py-10">Sin turnos en este período.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $turnos->links() }}</div>
    </div>
</div>
@endsection
