@extends('layouts.app')
@section('title', 'Kardex de Medicación')
@section('page-title', 'Kardex Diario de Medicación')
@section('breadcrumb')
    Medicación / Dashboard
@endsection

@section('content')
<div class="space-y-6">
    <!-- Filtro de Fecha -->
    <div class="filter-bar flex justify-between items-center">
        <form method="GET" action="{{ route('medication.dashboard') }}" class="flex items-center gap-4">
            <div>
                <label class="form-label mb-0 mr-2 inline-block">Fecha de Control:</label>
                <input type="date" name="fecha" value="{{ $fecha }}" onchange="this.form.submit()" class="form-input py-2 w-auto">
            </div>
        </form>
        <div class="text-sm font-medium text-slate-500">
            <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span> Pendientes
                <span class="w-3 h-3 rounded-full bg-emerald-500 ml-3"></span> Administrados
            </span>
        </div>
    </div>

    @if($administraciones->isEmpty())
        <div class="card p-20 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700">No hay dosis programadas</h3>
            <p class="text-slate-500">No se encontraron medicamentos para administrar en la fecha seleccionada.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach($administraciones as $admin)
                <div class="card p-5 {{ $admin->estado === 'pendiente' ? 'border-l-4 border-l-amber-500' : 'border-l-4 border-l-emerald-500' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="text-center min-w-[80px]">
                                <div class="text-2xl font-bold text-slate-800">{{ $admin->fecha_hora_programada->format('H:i') }}</div>
                                <div class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Hora</div>
                            </div>
                            
                            <div class="h-10 w-[1px] bg-slate-100"></div>

                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-bold text-teal-600 uppercase">{{ $admin->prescripcion->paciente->nombre_completo }}</span>
                                    <span class="text-[10px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full font-bold uppercase">{{ $admin->prescripcion->via_administracion }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $admin->prescripcion->medicamento }} - {{ $admin->prescripcion->dosis }}</h4>
                                <p class="text-xs text-slate-500 italic">{{ $admin->prescripcion->indicaciones ?? 'Sin indicaciones adicionales' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            @if($admin->estado === 'pendiente')
                                <button type="button" 
                                        onclick="confirmarAdministracion({{ $admin->id_administracion }}, '{{ $admin->prescripcion->medicamento }}')"
                                        class="btn-primary py-2 px-6">
                                    Marcar como Entregado
                                </button>
                            @else
                                <div class="text-right">
                                    <span class="badge-active mb-1 inline-block">Administrado</span>
                                    <div class="text-[10px] text-slate-400 font-medium">
                                        Por: {{ $admin->administra->nombre_usuario }} <br>
                                        A las: {{ $admin->fecha_hora_real->format('H:i') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Simple para Observaciones -->
<div id="modalAdmin" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-[2rem] p-8 max-w-md w-full shadow-2xl animate-fade-in">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Confirmar Administración</h3>
        <p class="text-slate-500 mb-6" id="modalText"></p>
        
        <form id="formAdmin" method="POST">
            @csrf
            <div class="mb-6">
                <label class="form-label">Observaciones (Opcional)</label>
                <textarea name="observaciones" rows="2" class="form-textarea" placeholder="Ej: Paciente lo tomó con dificultad..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1">Confirmar Entrega</button>
                <button type="button" onclick="closeModal()" class="btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmarAdministracion(id, medicamento) {
        document.getElementById('modalText').innerText = "¿Confirmas que has administrado " + medicamento + " al paciente?";
        document.getElementById('formAdmin').action = "/medication/" + id + "/administrar";
        document.getElementById('modalAdmin').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalAdmin').classList.add('hidden');
    }
</script>
@endsection
