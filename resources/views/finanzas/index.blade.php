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
            <h3 class="font-semibold text-slate-800 mb-3">Ingresos del Período</h3>
            @if($ingresos->isEmpty())
                <p class="text-slate-400 text-sm">Sin ingresos en este período.</p>
            @else
            <div class="space-y-2">
                @foreach($ingresos as $i)
                <div class="flex items-start gap-3 py-2 border-b border-slate-100 last:border-0">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700 truncate">{{ $i->concepto }}</p>
                        <p class="text-xs text-slate-400">{{ $i->metodo_pago }} · {{ $i->fecha_ingreso->format('d/m/Y') }}</p>
                    </div>
                    <p class="text-sm font-bold text-emerald-700">S/ {{ number_format($i->monto, 2) }}</p>
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
