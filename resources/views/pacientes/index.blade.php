@extends('layouts.app')
@section('title','Pacientes')
@section('page-title','Gestión de Pacientes')
@section('header-actions')
<a href="{{ route('pacientes.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Nuevo Paciente
</a>
@endsection
@section('content')
<div class="space-y-4">
    <form method="GET" class="filter-bar items-center">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar nombre o documento..." class="form-input max-w-xs">
        <select name="estado" class="form-select w-36">
            <option value="">Todos</option>
            <option value="1" @selected(request('estado')==='1')>Activo</option>
            <option value="0" @selected(request('estado')==='0')>Inactivo</option>
        </select>
        <button type="submit" class="btn-primary">Buscar</button>
        <a href="{{ route('pacientes.index') }}" class="btn-secondary">Limpiar</a>
    </form>
    <div class="card p-0 overflow-hidden">
        <div class="table-container">
            <table class="table">
                <thead><tr>
                    <th>#</th><th>Nombre</th><th>Documento</th><th>Edad</th>
                    <th>Contacto Emergencia</th><th>Ingreso</th><th>Estado</th><th class="text-right">Acciones</th>
                </tr></thead>
                <tbody>
                @forelse($pacientes as $p)
                <tr>
                    <td class="text-slate-400 text-xs">{{ $p->id_paciente }}</td>
                    <td class="font-medium">{{ $p->nombre_completo }}</td>
                    <td class="text-xs text-slate-500">{{ $p->tipo_documento }}: {{ $p->numero_documento }}</td>
                    <td>{{ $p->edad }} años</td>
                    <td class="text-sm">{{ $p->contacto_emergencia ?? '—' }}</td>
                    <td class="text-xs text-slate-500">{{ $p->fecha_ingreso->format('d/m/Y') }}</td>
                    <td><span @class(['badge-active'=>$p->estado,'badge-inactive'=>!$p->estado])>{{ $p->estado?'Activo':'Inactivo' }}</span></td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('pacientes.show', $p) }}" class="btn-secondary py-1 px-2 text-xs">Ver</a>
                            <a href="{{ route('pacientes.edit', $p) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-slate-400 py-10">Sin pacientes registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-100">{{ $pacientes->links() }}</div>
    </div>
</div>
@endsection
