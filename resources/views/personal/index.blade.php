@extends('layouts.app')
@section('title', 'Personal')
@section('page-title', 'Gestión de Personal')

@section('header-actions')
    <a href="{{ route('personal.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo Personal
    </a>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Filtros --}}
    <form method="GET" class="filter-bar items-center">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o documento..." class="form-input max-w-xs">
        <select name="estado" class="form-select w-36">
            <option value="">Todos los estados</option>
            <option value="1" @selected(request('estado')==='1')>Activo</option>
            <option value="0" @selected(request('estado')==='0')>Inactivo</option>
        </select>
        <button type="submit" class="btn-primary">Buscar</button>
        <a href="{{ route('personal.index') }}" class="btn-secondary">Limpiar</a>
    </form>

    {{-- Tabla --}}
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Cargo</th>
                        <th>Modalidad</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personal as $p)
                    <tr>
                        <td class="text-slate-400 text-xs">{{ $p->id_personal }}</td>
                        <td class="font-medium">{{ $p->nombre_completo }}</td>
                        <td class="text-slate-500 text-xs">{{ $p->tipo_documento }}: {{ $p->numero_documento }}</td>
                        <td>{{ $p->cargo }}</td>
                        <td><span class="badge-info">{{ $p->modalidad_contrato }}</span></td>
                        <td class="text-slate-500">{{ $p->telefono ?? '—' }}</td>
                        <td>
                            <span @class(['badge-active' => $p->estado, 'badge-inactive' => !$p->estado])>
                                {{ $p->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('personal.edit', $p) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                                <form method="POST" action="{{ route('personal.destroy', $p) }}" onsubmit="return confirm('¿Desactivar este personal?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger py-1 px-2 text-xs">Desactivar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-slate-400 py-10">No hay personal registrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">
            {{ $personal->links() }}
        </div>
    </div>
</div>
@endsection
