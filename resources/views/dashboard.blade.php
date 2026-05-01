@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Resumen General')

@section('content')
<div class="space-y-8 animate-fade-in">

    {{-- ── Welcome Banner ── --}}
    <div class="banner-gradient">
        <div class="banner-pattern"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight mb-2">¡Hola, {{ auth()->user()->nombre_usuario }}! 👋</h1>
                <p class="text-teal-100/80 max-w-md">El sistema de CasaHogar está funcionando correctamente. Tienes {{ $stats['facturas_pendientes'] }} facturas pendientes por revisar hoy.</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('pacientes.create') }}" class="btn-primary !bg-white !text-teal-900 shadow-xl border-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Paciente
                    </a>
                    <a href="{{ route('facturacion.create') }}" class="btn-secondary !bg-white/10 !text-white !border-white/20 backdrop-blur-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Generar Factura
                    </a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-teal-500/20 rounded-full blur-3xl"></div>
                <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-6 shadow-2xl min-w-[240px]">
                    <p class="text-teal-400 text-[10px] font-bold uppercase tracking-widest mb-1">Estado del Sistema</p>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                        <span class="text-white font-semibold">Servidores Activos</span>
                    </div>
                    <div class="space-y-2">
                        <div class="h-1.5 w-full bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-teal-400 w-3/4"></div>
                        </div>
                        <p class="text-white/50 text-[10px]">Ocupación actual: 75%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Key Metrics ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        @php
            $cards = [
                ['label' => 'Pacientes', 'value' => $stats['pacientes_activos'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0', 'color' => 'teal'],
                ['label' => 'Personal', 'value' => $stats['personal_activo'], 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'indigo'],
                ['label' => 'Turnos Hoy', 'value' => $stats['turnos_hoy'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'amber'],
                ['label' => 'Ingresos Mes', 'value' => 'S/ '.number_format($stats['ingresos_mes'], 0), 'icon' => 'M7 11l5-5m0 0l5 5m-5-5v12', 'color' => 'emerald'],
                ['label' => 'Egresos Mes', 'value' => 'S/ '.number_format($stats['egresos_mes'], 0), 'icon' => 'M17 13l-5 5m0 0l-5-5m5 5V6', 'color' => 'rose'],
                ['label' => 'Fact. Pend.', 'value' => $stats['facturas_pendientes'], 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'orange'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="stat-card glass-glow group">
            <div class="stat-icon bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800 tracking-tight">{{ $card['value'] }}</p>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $card['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Main Sections ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- List: Patients --}}
        <div class="card card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Últimos Pacientes</h3>
                    <p class="text-xs text-slate-400">Nuevos ingresos de esta semana</p>
                </div>
                <a href="{{ route('pacientes.index') }}" class="btn-secondary !py-1.5 !px-3 !text-xs !rounded-lg">Ver todos</a>
            </div>
            
            <div class="space-y-4">
                @forelse($ultimosPacientes as $p)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                    <div class="w-10 h-10 bg-gradient-to-tr from-teal-500 to-teal-400 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-teal-500/20">
                        {{ strtoupper(substr($p->nombres, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700 truncate">{{ $p->nombre_completo }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Ingreso: {{ $p->fecha_ingreso->format('d/m/Y') }}</p>
                    </div>
                    <span class="premium-badge {{ $p->estado ? 'badge-success' : 'badge-danger' }}">
                        {{ $p->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <p class="text-slate-400 text-sm">No hay registros recientes</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- List: Invoices --}}
        <div class="card card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Últimas Facturas</h3>
                    <p class="text-xs text-slate-400">Control de facturación reciente</p>
                </div>
                <a href="{{ route('facturacion.index') }}" class="btn-secondary !py-1.5 !px-3 !text-xs !rounded-lg">Ir a módulo</a>
            </div>
            
            <div class="space-y-4">
                @forelse($ultimasFact as $f)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                    <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-teal-400 shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-700">{{ $f->serie }}-{{ $f->correlativo }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase truncate">{{ optional($f->paciente)->nombre_completo }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-extrabold text-slate-800">S/ {{ number_format($f->total, 2) }}</p>
                        <p class="text-[9px] font-bold text-emerald-500 uppercase">Emitida</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-slate-400 text-sm">No hay facturas este mes</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
