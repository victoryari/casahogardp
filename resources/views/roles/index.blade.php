@extends('layouts.app')
@section('title','Roles')
@section('page-title','Gestión de Roles')
@section('header-actions')
<a href="{{ route('roles.create') }}" class="btn-primary">+ Nuevo Rol</a>
@endsection
@section('content')
<div class="card p-0 overflow-hidden">
    <div class="table-container">
        <table class="table">
            <thead><tr><th>#</th><th>Nombre del Rol</th><th>Descripción</th><th>Usuarios</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
            @forelse($roles as $r)
            <tr>
                <td class="text-slate-400 text-xs">{{ $r->id_rol }}</td>
                <td class="font-semibold">{{ $r->nombre_rol }}</td>
                <td class="text-slate-500 text-sm">{{ $r->descripcion ?? '—' }}</td>
                <td><span class="badge-info">{{ $r->usuarios_count }}</span></td>
                <td><span @class(['badge-active'=>$r->estado,'badge-inactive'=>!$r->estado])>{{ $r->estado?'Activo':'Inactivo' }}</span></td>
                <td class="text-right">
                    <a href="{{ route('roles.edit', $r) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-400 py-10">Sin roles.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
