@extends('layouts.app')
@section('title','Usuarios')
@section('page-title','Gestión de Usuarios')
@section('header-actions')
<a href="{{ route('usuarios.create') }}" class="btn-primary">+ Nuevo Usuario</a>
@endsection
@section('content')
<div class="card p-0 overflow-hidden">
    <div class="table-container">
        <table class="table">
            <thead><tr><th>#</th><th>Usuario</th><th>Rol</th><th>Personal Vinculado</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
            <tbody>
            @forelse($usuarios as $u)
            <tr>
                <td class="text-slate-400 text-xs">{{ $u->id_usuario }}</td>
                <td class="font-medium">{{ $u->nombre_usuario }}</td>
                <td><span class="badge-info">{{ optional($u->rol)->nombre_rol ?? '—' }}</span></td>
                <td class="text-slate-500 text-sm">{{ optional($u->personal)->nombre_completo ?? '—' }}</td>
                <td><span @class(['badge-active'=>$u->estado,'badge-inactive'=>!$u->estado])>{{ $u->estado?'Activo':'Inactivo' }}</span></td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('usuarios.edit', $u) }}" class="btn-secondary py-1 px-2 text-xs">Editar</a>
                        @if($u->id_usuario !== auth()->id())
                        <form method="POST" action="{{ route('usuarios.destroy', $u) }}" onsubmit="return confirm('¿Desactivar usuario?')">
                            @csrf @method('DELETE')
                            <button class="btn-danger py-1 px-2 text-xs">Desactivar</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-slate-400 py-10">Sin usuarios.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-100">{{ $usuarios->links() }}</div>
</div>
@endsection
