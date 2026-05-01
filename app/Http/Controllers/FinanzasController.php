<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class FinanzasController extends Controller
{
    public function index(Request $request)
    {
        $mes  = (int) $request->get('mes', now()->month);
        $anio = (int) $request->get('anio', now()->year);

        $ingresos = Ingreso::whereMonth('fecha_ingreso', $mes)
            ->whereYear('fecha_ingreso', $anio)->where('estado', 1)
            ->latest('fecha_ingreso')->get();

        $egresos = Egreso::whereMonth('fecha_egreso', $mes)
            ->whereYear('fecha_egreso', $anio)->where('estado', 1)
            ->latest('fecha_egreso')->get();

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos  = $egresos->sum('monto');
        $balance       = $totalIngresos - $totalEgresos;

        return view('finanzas.index', compact('ingresos', 'egresos', 'totalIngresos', 'totalEgresos', 'balance', 'mes', 'anio'));
    }

    public function createIngreso()
    {
        return view('finanzas.create_ingreso');
    }

    public function storeIngreso(Request $request)
    {
        $data = $request->validate([
            'concepto'               => 'required|string|max:255',
            'monto'                  => 'required|numeric|min:0.01',
            'metodo_pago'            => 'required|string|max:50',
            'comprobante_referencia' => 'nullable|string|max:100',
            'fecha_ingreso'          => 'required|date',
        ]);
        $data['id_usuario_registro'] = auth()->id();
        $i = Ingreso::create($data);
        BitacoraSistema::registrar('CREAR', 'ingresos', $i->id_ingreso, "Ingreso: S/ {$i->monto}");
        return redirect()->route('finanzas.index')->with('success', 'Ingreso registrado correctamente.');
    }

    public function createEgreso()
    {
        return view('finanzas.create_egreso');
    }

    public function storeEgreso(Request $request)
    {
        $data = $request->validate([
            'concepto'               => 'required|string|max:255',
            'categoria'              => 'nullable|string|max:100',
            'monto'                  => 'required|numeric|min:0.01',
            'metodo_pago'            => 'required|string|max:50',
            'comprobante_referencia' => 'nullable|string|max:100',
            'fecha_egreso'           => 'required|date',
        ]);
        $data['id_usuario_registro'] = auth()->id();
        $e = Egreso::create($data);
        BitacoraSistema::registrar('CREAR', 'egresos', $e->id_egreso, "Egreso: S/ {$e->monto}");
        return redirect()->route('finanzas.index')->with('success', 'Egreso registrado correctamente.');
    }
}
