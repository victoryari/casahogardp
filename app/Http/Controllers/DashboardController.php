<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Personal;
use App\Models\Factura;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\AsignacionTurno;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pacientes_activos'  => Paciente::where('estado', 1)->count(),
            'personal_activo'    => Personal::where('estado', 1)->count(),
            'turnos_hoy'         => AsignacionTurno::where('fecha_turno', today())->where('estado', 1)->count(),
            'ingresos_mes'       => Ingreso::whereMonth('fecha_ingreso', now()->month)
                                       ->whereYear('fecha_ingreso', now()->year)
                                       ->where('estado', 1)->sum('monto'),
            'egresos_mes'        => Egreso::whereMonth('fecha_egreso', now()->month)
                                       ->whereYear('fecha_egreso', now()->year)
                                       ->where('estado', 1)->sum('monto'),
            'facturas_pendientes'=> Factura::where('estado', 0)->count(),
        ];

        $ultimosPacientes = Paciente::where('estado', 1)->latest('fecha_registro')->take(5)->get();
        $ultimasFact      = Factura::with('paciente')->latest('fecha_registro')->take(5)->get();

        return view('dashboard', compact('stats', 'ultimosPacientes', 'ultimasFact'));
    }
}
