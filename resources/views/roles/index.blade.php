@extends('layouts.app')
@section('title','Roles de Usuario')
@section('page-title','Gestión de Roles')
@section('header-actions')
<a href="{{ route('roles.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Nuevo Rol
</a>
@endsection

@section('content')
<div class="card p-0 overflow-hidden">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del Rol</th>
                    <th>Descripción</th>
                    <th class="text-center">Usuarios</th>
                    <th class="text-center">Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $r)
                <tr>
                    <td class="font-bold text-slate-700">{{ $r->nombre_rol }}</td>
                    <td class="text-sm text-slate-500 max-w-xs truncate">{{ $r->descripcion ?? 'Sin descripción' }}</td>
                    <td class="text-center">
                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-600 bg-teal-50 rounded-full">
                            {{ $r->usuarios_count }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span @class(['badge-active'=>$r->estado,'badge-inactive'=>!$r->estado])>
                            {{ $r->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('roles.edit', $r) }}" class="btn-secondary py-1 px-3 text-xs">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
