<?php

namespace App\Http\Controllers;

use App\Models\AsignacionTurno;
use App\Models\Personal;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index(Request $request)
    {
        $query = AsignacionTurno::with('personal', 'usuarioAsigno');
        if ($request->filled('fecha')) {
            $query->where('fecha_turno', $request->fecha);
        } else {
            $query->where('fecha_turno', '>=', now()->subDays(7));
        }
        if ($request->filled('id_personal')) {
            $query->where('id_personal', $request->id_personal);
        }
        $turnos   = $query->orderBy('fecha_turno', 'desc')->paginate(20)->withQueryString();
        $personal = Personal::where('estado', 1)->orderBy('apellidos')->get();
        return view('turnos.index', compact('turnos', 'personal'));
    }

    public function create()
    {
        $personal = Personal::where('estado', 1)->orderBy('apellidos')->get();
        return view('turnos.create', compact('personal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_personal'  => 'required|exists:personal,id_personal',
            'fecha_turno'  => 'required|date',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i|after:hora_inicio',
        ]);
        $data['id_usuario_asigno'] = auth()->id();
        $t = AsignacionTurno::create($data);
        BitacoraSistema::registrar('CREAR', 'asignacion_turnos', $t->id_asignacion, "Turno asignado");
        return redirect()->route('turnos.index')->with('success', 'Turno asignado correctamente.');
    }

    public function edit(AsignacionTurno $turno)
    {
        $personal = Personal::where('estado', 1)->orderBy('apellidos')->get();
        return view('turnos.edit', compact('turno', 'personal'));
    }

    public function update(Request $request, AsignacionTurno $turno)
    {
        $data = $request->validate([
            'id_personal'  => 'required|exists:personal,id_personal',
            'fecha_turno'  => 'required|date',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i|after:hora_inicio',
            'estado'       => 'required|boolean',
        ]);
        $turno->update($data);
        BitacoraSistema::registrar('EDITAR', 'asignacion_turnos', $turno->id_asignacion, "Turno actualizado");
        return redirect()->route('turnos.index')->with('success', 'Turno actualizado.');
    }

    public function destroy(AsignacionTurno $turno)
    {
        $turno->update(['estado' => 0]);
        return redirect()->route('turnos.index')->with('success', 'Turno cancelado.');
    }
}
