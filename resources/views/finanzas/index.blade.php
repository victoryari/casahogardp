@extends('layouts.app')
@section('title','Finanzas')
@section('page-title','Finanzas')
@section('header-actions')
<div class="flex gap-2">
    <a href="{{ route('finanzas.ingreso.create') }}" class="btn-primary">+ Ingreso</a>
    <a href="{{ route('finanzas.egreso.create') }}" class="btn-secondary">+ Egreso</a>
</div>
@endsection
@section('content')
<div class="space-y-5">
    {{-- Filtro mes --}}
    <form method="GET" class="filter-bar items-center">
        <div><label class="text-xs text-slate-500 font-medium block mb-1">Mes</label>
            <select name="mes" class="form-select w-32">
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}" @selected($m==$mes)>{{ \Carbon\Carbon::create()->month($m)->locale('es')->isoFormat('MMMM') }}</option>
                @endforeach
            </select></div>
        <div><label class="text-xs text-slate-500 font-medium block mb-1">Año</label>
            <select name="anio" class="form-select w-24">
                @foreach(range(now()->year, now()->year-3) as $y)
                <option value="{{ $y }}" @selected($y==$anio)>{{ $y }}</option>
                @endforeach
            </select></div>
        <div class="self-end"><button type="submit" class="btn-primary">Filtrar</button></div>
    </form>

    {{-- Balance cards --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="stat-card">
            <div class="stat-icon bg-emerald-50"><svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg></div>
            <div><p class="text-xl font-bold text-emerald-700">S/ {{ number_format($totalIngresos, 2) }}</p><p class="text-xs text-slate-500">Total Ingresos</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-red-50"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg></div>
            <div><p class="text-xl font-bold text-red-600">S/ {{ number_format($totalEgresos, 2) }}</p><p class="text-xs text-slate-500">Total Egresos</p></div>
        </div>
        <div class="stat-card">
            <div @class(['stat-icon'=>true,'bg-teal-50'=>$balance>=0,'bg-orange-50'=>$balance<0])>
                <svg class="w-5 h-5 {{ $balance>=0?'text-teal-600':'text-orange-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"/></svg>
            </div>
            <div><p class="text-xl font-bold {{ $balance>=0?'text-teal-700':'text-orange-600' }}">S/ {{ number_format($balance, 2) }}</p><p class="text-xs text-slate-500">Balance</p></div>
        </div>
    </div>

    {{-- Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-800">Detalle de Ingresos</h3>
                <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Total: S/ {{ number_format($totalIngresos, 2) }}</span>
            </div>
            
            @if($ingresos->isEmpty() && $facturas->isEmpty())
                <p class="text-slate-400 text-sm py-8 text-center">Sin ingresos registrados en este período.</p>
            @else
            <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                {{-- Facturas --}}
                @foreach($facturas as $f)
                <div class="flex items-start gap-3 py-3 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors rounded-xl px-2 -mx-2">
                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[9px] font-bold text-teal-600 bg-teal-50 px-1.5 py-0.5 rounded uppercase">Factura</span>
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $f->serie }}-{{ $f->correlativo }}</p>
                        </div>
                        <p class="text-xs text-slate-500 truncate">{{ optional($f->paciente)->nombre_completo ?? 'Paciente General' }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $f->fecha_emision->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-teal-700">S/ {{ number_format($f->total, 2) }}</p>
                    </div>
                </div>
                @endforeach

                {{-- Ingresos Manuales --}}
                @foreach($ingresos as $i)
                <div class="flex items-start gap-3 py-3 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors rounded-xl px-2 -mx-2">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase">Manual</span>
                            <p class="text-sm font-bold text-slate-700 truncate">{{ $i->concepto }}</p>
                        </div>
                        <p class="text-xs text-slate-500">{{ $i->metodo_pago }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $i->fecha_ingreso->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-emerald-700">S/ {{ number_format($i->monto, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="card">
            <h3 class="font-semibold text-slate-800 mb-3">Egresos del Período</h3>
            @if($egresos->isEmpty())
                <p class="text-slate-400 text-sm">Sin egresos en este período.</p>
            @else
            <div class="space-y-2">
                @foreach($egresos as $e)
                <div class="flex items-start gap-3 py-2 border-b border-slate-100 last:border-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $e->concepto }}</p>
                        <p class="text-xs text-slate-400">{{ $e->categoria ?? 'General' }} · {{ $e->fecha_egreso->format('d/m/Y') }}</p>
                    </div>
                    <p class="text-sm font-bold text-red-600">S/ {{ number_format($e->monto, 2) }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
