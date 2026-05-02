@extends('layouts.app')
@section('title','Usuarios')
@section('page-title','Gestión de Usuarios')
@section('header-actions')
<a href="{{ route('usuarios.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
    Nuevo Usuario
</a>
@endsection

@section('content')
<div class="card p-0 overflow-hidden">
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Personal Asociado</th>
                    <th>Rol</th>
                    <th class="text-center">Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500 font-bold text-xs">
                                {{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}
                            </div>
                            <span class="font-bold text-slate-700">{{ $u->nombre_usuario }}</span>
                        </div>
                    </td>
                    <td>
                        @if($u->personal)
                            <div class="text-sm font-medium text-slate-700">{{ $u->personal->nombre_completo }}</div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $u->personal->cargo }}</div>
                        @else
                            <span class="text-xs text-slate-400 italic">No vinculado</span>
                        @endif
                    </td>
                    <td>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                            {{ optional($u->rol)->nombre_rol ?? 'Sin Rol' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span @class(['badge-active'=>$u->estado,'badge-inactive'=>!$u->estado])>
                            {{ $u->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('usuarios.edit', $u) }}" class="btn-secondary py-1 px-3 text-xs">Editar</a>
                            @if($u->id_usuario !== auth()->id())
                            <form action="{{ route('usuarios.destroy', $u) }}" method="POST" onsubmit="return confirm('¿Desactivar este usuario?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger py-1 px-3 text-xs">Anular</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-100">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
