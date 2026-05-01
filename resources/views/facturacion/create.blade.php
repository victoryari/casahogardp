@extends('layouts.app')
@section('title','Nueva Factura')
@section('page-title','Emitir Factura')
@section('breadcrumb')
    <a href="{{ route('facturacion.index') }}" class="hover:text-teal-600">Facturación</a> / Nueva
@endsection
@push('styles')
<style>
#servicios-container .servicio-row:not(:last-child) { border-bottom: 1px solid #f1f5f9; }
</style>
@endpush
@section('content')
<div class="max-w-3xl"><div class="card">
<form method="POST" action="{{ route('facturacion.store') }}" id="form-factura" class="space-y-6">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div><label class="form-label">Paciente *</label>
            <select name="id_paciente" class="form-select" required>
                <option value="">Seleccionar paciente...</option>
                @foreach($pacientes as $p)
                <option value="{{ $p->id_paciente }}" @selected(old('id_paciente')==$p->id_paciente)>{{ $p->nombre_completo }}</option>
                @endforeach
            </select>
            @error('id_paciente')<p class="form-error">{{ $message }}</p>@enderror</div>
        <div><label class="form-label">Fecha de Emisión *</label>
            <input type="date" name="fecha_emision" value="{{ old('fecha_emision', date('Y-m-d')) }}" class="form-input" required></div>
    </div>

    {{-- Comprobante --}}
    <div class="bg-slate-50 rounded-xl p-4">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Comprobante</p>
        <p class="text-slate-700 text-sm">Serie: <span class="font-mono font-bold">{{ $serie }}</span> &nbsp; Correlativo: <span class="font-mono font-bold">{{ $correlativo }}</span></p>
    </div>

    {{-- Servicios --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <label class="form-label mb-0">Servicios *</label>
            <button type="button" id="btn-add-servicio" class="btn-secondary text-xs py-1">+ Agregar servicio</button>
        </div>
        <div id="servicios-container" class="border border-slate-200 rounded-xl overflow-hidden">
            <div class="servicio-row grid grid-cols-12 gap-2 p-3 items-end bg-slate-50">
                <div class="col-span-6"><label class="text-xs text-slate-500 font-medium">Servicio</label>
                    <select name="servicios[0][id]" class="form-select mt-1 servicio-select" required>
                        <option value="">Seleccionar...</option>
                        @foreach($servicios as $s)
                        <option value="{{ $s->id_servicio }}" data-precio="{{ $s->precio_referencial }}">{{ $s->nombre_servicio }}</option>
                        @endforeach
                    </select></div>
                <div class="col-span-2"><label class="text-xs text-slate-500 font-medium">Cantidad</label>
                    <input type="number" name="servicios[0][cantidad]" value="1" min="1" step="0.01" class="form-input mt-1 cant-input" required></div>
                <div class="col-span-3"><label class="text-xs text-slate-500 font-medium">Precio Unit. (S/)</label>
                    <input type="number" name="servicios[0][precio]" value="0" step="0.01" class="form-input mt-1 precio-input" required></div>
                <div class="col-span-1 flex items-end justify-center">
                    <button type="button" class="text-slate-300 hover:text-red-500 btn-remove-servicio transition-colors" title="Eliminar">✕</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Totales --}}
    <div class="bg-teal-50 rounded-xl p-4 text-sm space-y-1.5">
        <div class="flex justify-between text-slate-600"><span>Subtotal</span><span id="display-subtotal">S/ 0.00</span></div>
        <div class="flex justify-between text-slate-600"><span>IGV (18%)</span><span id="display-igv">S/ 0.00</span></div>
        <div class="flex justify-between font-bold text-slate-800 text-base border-t border-teal-200 pt-2 mt-2"><span>Total</span><span id="display-total" class="text-teal-700">S/ 0.00</span></div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">Emitir Factura</button>
        <a href="{{ route('facturacion.index') }}" class="btn-secondary">Cancelar</a>
    </div>
</form>
</div></div>
@endsection

@push('scripts')
<script>
let idx = 1;
const serviciosData = @json($servicios->pluck('precio_referencial','id_servicio'));

function recalcular() {
    let sub = 0;
    document.querySelectorAll('.servicio-row').forEach(row => {
        const cant  = parseFloat(row.querySelector('.cant-input')?.value || 0);
        const precio= parseFloat(row.querySelector('.precio-input')?.value || 0);
        sub += cant * precio;
    });
    const igv   = sub * 0.18;
    const total  = sub + igv;
    document.getElementById('display-subtotal').textContent = 'S/ ' + sub.toFixed(2);
    document.getElementById('display-igv').textContent      = 'S/ ' + igv.toFixed(2);
    document.getElementById('display-total').textContent    = 'S/ ' + total.toFixed(2);
}

function addListeners(row) {
    row.querySelector('.servicio-select')?.addEventListener('change', function() {
        const precio = serviciosData[this.value] || 0;
        row.querySelector('.precio-input').value = precio;
        recalcular();
    });
    row.querySelectorAll('.cant-input,.precio-input').forEach(i => i.addEventListener('input', recalcular));
    row.querySelector('.btn-remove-servicio')?.addEventListener('click', function() {
        if (document.querySelectorAll('.servicio-row').length > 1) { row.remove(); recalcular(); }
    });
}

document.querySelectorAll('.servicio-row').forEach(addListeners);

document.getElementById('btn-add-servicio').addEventListener('click', function() {
    const tpl = document.querySelector('.servicio-row').cloneNode(true);
    tpl.querySelectorAll('select,input').forEach(el => {
        el.name = el.name.replace(/\[\d+\]/, '[' + idx + ']');
        if (el.tagName==='SELECT') el.selectedIndex=0;
        else el.value = el.classList.contains('cant-input') ? 1 : 0;
    });
    document.getElementById('servicios-container').appendChild(tpl);
    addListeners(tpl);
    idx++;
});
</script>
@endpush
