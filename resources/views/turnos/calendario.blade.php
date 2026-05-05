@extends('layouts.app')
@section('title','Calendario de Turnos')
@section('page-title','Programación Mensual')
@section('header-actions')
<a href="{{ route('turnos.index') }}" class="btn-secondary">Volver al Listado</a>
@endsection

@section('content')
<div class="card p-6" x-data="{ 
    currentDate: new Date(),
    get daysInMonth() {
        return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
    },
    get startDay() {
        return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
    },
    get monthName() {
        return new Intl.DateTimeFormat('es', { month: 'long' }).format(this.currentDate);
    },
    nextMonth() {
        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
    },
    prevMonth() {
        this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
    }
}">
    {{-- Calendar Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <h2 class="text-2xl font-bold text-slate-800 capitalize" x-text="monthName + ' ' + currentDate.getFullYear()"></h2>
            <div class="flex bg-slate-100 rounded-xl p-1">
                <button @click="prevMonth()" class="p-2 hover:bg-white hover:shadow-sm rounded-lg transition-all">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="nextMonth()" class="p-2 hover:bg-white hover:shadow-sm rounded-lg transition-all">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        <div class="flex gap-4 text-xs font-medium text-slate-500">
            <div class="flex items-center gap-2"><span class="w-3 h-3 bg-teal-500 rounded-full"></span> Turnos Aprobados</div>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="grid grid-cols-7 gap-px bg-slate-200 border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        {{-- Days of Week --}}
        @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $day)
        <div class="bg-slate-50 py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
            {{ $day }}
        </div>
        @endforeach

        {{-- Blank spaces for start of month --}}
        <template x-for="i in startDay">
            <div class="bg-white min-h-[120px] p-2"></div>
        </template>

        {{-- Days of Month --}}
        <template x-for="day in daysInMonth">
            <div class="bg-white min-h-[120px] p-2 hover:bg-slate-50 transition-colors group relative">
                <span class="text-sm font-bold text-slate-400 group-hover:text-teal-600 transition-colors" x-text="day"></span>
                
                {{-- Turnos for this day --}}
                <div class="mt-2 space-y-1">
                    @foreach($turnos as $t)
                        <div 
                            x-show="currentDate.getMonth() === {{ $t->fecha_turno->month - 1 }} && currentDate.getFullYear() === {{ $t->fecha_turno->year }} && day === {{ $t->fecha_turno->day }}"
                            class="text-[10px] p-1.5 bg-teal-50 text-teal-700 rounded-lg border border-teal-100 shadow-sm leading-tight"
                        >
                            <p class="font-bold truncate">{{ $t->personal->nombre_completo }}</p>
                            <p class="opacity-75">{{ $t->hora_inicio }} - {{ $t->hora_fin }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </template>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
</style>
@endsection
