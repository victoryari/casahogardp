@extends('layouts.app')
@section('title','Nuevo Ingreso')
@section('page-title','Registrar Ingreso')
@section('breadcrumb')
    <a href="{{ route('finanzas.index') }}" class="hover:text-teal-600">Finanzas</a> / Ingreso
@endsection
@section('content')
<div class="max-w-lg"><div class="card">
<form method="POST" action="{{ route('finanzas.ingreso.store') }}" class="space-y-5">
    @csrf
    <div><label class="form-label">Concepto *</label>
        <input type="text" name="concepto" value="{{ old('concepto') }}" class="form-input @error('concepto') is-invalid @enderror" required>
        @error('concepto')<p class="form-error">{{ $message }}</p>@enderror</div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Monto (S/) *</label>
            <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" class="form-input" required></div>
        <div><label class="form-label">Método de Pago *</label>
            <select name="metodo_pago" class="form-select">
                @foreach(['Efectivo','Transferencia','Yape','Plin','Tarjeta','Cheque'] as $m)
                <option value="{{ $m }}" @selected(old('metodo_pago')===$m)>{{ $m }}</option>
                @endforeach
            </select></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Fecha *</label>
            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', date('Y-m-d')) }}" class="form-input" required></div>
        <div><label class="form-label">Comprobante / Referencia</label>
            <input type="text" name="comprobante_referencia" value="{{ old('comprobante_referencia') }}" class="form-input"></div>
    </div>
    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">Registrar Ingreso</button>
        <a href="{{ route('finanzas.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection
