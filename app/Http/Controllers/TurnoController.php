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
        $user = auth()->user();
        $canManage = $user->esAdmin() || $user->tienePermiso('turnos.gestionar');
        
        $query = AsignacionTurno::with('personal', 'usuarioAsigno', 'usuarioValida');

        // Filtros básicos
        if ($request->filled('fecha')) {
            $query->where('fecha_turno', $request->fecha);
        }
        
        if ($request->filled('id_personal')) {
            $query->where('id_personal', $request->id_personal);
        }

        if ($request->filled('estado_aprobacion')) {
            $query->where('estado_aprobacion', $request->estado_aprobacion);
        }

        if ($request->filled('buscar')) {
            $query->whereHas('personal', fn($q) => $q->where('nombres', 'like', "%{$request->buscar}%")
                ->orWhere('apellidos', 'like', "%{$request->buscar}%"));
        }

        // Si NO es gestor, solo ve sus propios turnos (pendientes y aprobados)
        // o los aprobados de los demás.
        if (!$canManage) {
            $query->where(function($q) use ($user) {
                $q->where('id_personal', $user->id_personal)
                  ->orWhere('estado_aprobacion', 'aprobado');
            });
        }

        $turnos   = $query->orderBy('fecha_turno', 'desc')->paginate(20)->withQueryString();
        $personal = Personal::where('estado', 1)->orderBy('apellidos')->get();
        
        return view('turnos.index', compact('turnos', 'personal', 'canManage'));
    }

    public function create()
    {
        $personal = Personal::where('estado', 1)->orderBy('apellidos')->get();
        return view('turnos.create', compact('personal'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $canManage = $user->esAdmin() || $user->tienePermiso('turnos.gestionar');
        
        $rules = [
            'fecha_turno'  => 'required|date|after_or_equal:today',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i|after:hora_inicio',
        ];

        if ($canManage) {
            $rules['id_personal'] = 'required|exists:personal,id_personal';
        }

        $data = $request->validate($rules);

        if (!$canManage) {
            if (!$user->id_personal) {
                return back()->with('error', 'Su usuario no está vinculado a un perfil de personal.');
            }
            $data['id_personal'] = $user->id_personal;
            $data['estado_aprobacion'] = 'pendiente';
        } else {
            $data['estado_aprobacion'] = 'aprobado';
            $data['id_usuario_valida'] = $user->id_usuario;
            $data['fecha_validacion']  = now();
        }

        $data['id_usuario_asigno'] = $user->id_usuario;
        $t = AsignacionTurno::create($data);
        
        BitacoraSistema::registrar('CREAR', 'asignacion_turnos', $t->id_asignacion, "Turno propuesto/asignado");
        return redirect()->route('turnos.index')->with('success', 'Turno registrado correctamente.');
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
        // Solo puede eliminar si es Admin o si es el dueño y está pendiente
        $user = auth()->user();
        $canManage = $user->esAdmin() || $user->tienePermiso('turnos.gestionar');
        
        if (!$canManage && ($turno->id_personal !== $user->id_personal || $turno->estado_aprobacion !== 'pendiente')) {
            return back()->with('error', 'No tiene permiso para cancelar este turno.');
        }

        $turno->update(['estado' => 0]);
        BitacoraSistema::registrar('ELIMINAR', 'asignacion_turnos', $turno->id_asignacion, "Turno cancelado");
        return redirect()->route('turnos.index')->with('success', 'Turno cancelado.');
    }

    public function validar(Request $request, AsignacionTurno $turno)
    {
        if (!auth()->user()->esAdmin() && !auth()->user()->tienePermiso('turnos.gestionar')) {
            abort(403, 'No tiene permiso para validar turnos.');
        }
        
        $request->validate(['accion' => 'required|in:aprobado,rechazado']);
        
        $turno->update([
            'estado_aprobacion' => $request->accion,
            'id_usuario_valida' => auth()->id(),
            'fecha_validacion'  => now(),
            'comentarios_aprobacion' => $request->comentarios
        ]);

        BitacoraSistema::registrar('VALIDAR', 'asignacion_turnos', $turno->id_asignacion, "Turno {$request->accion}");
        return back()->with('success', "Turno {$request->accion} correctamente.");
    }

    public function calendario()
    {
        $turnos = AsignacionTurno::with('personal')
            ->where('estado', 1)
            ->where('estado_aprobacion', 'aprobado')
            ->get();
            
        return view('turnos.calendario', compact('turnos'));
    }
}
