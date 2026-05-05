<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::query();
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombres', 'like', "%{$request->buscar}%")
                  ->orWhere('apellidos', 'like', "%{$request->buscar}%")
                  ->orWhere('numero_documento', 'like', "%{$request->buscar}%");
            });
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        $pacientes = $query->orderBy('apellidos')->paginate(15)->withQueryString();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres'              => 'required|string|max:100',
            'apellidos'            => 'required|string|max:100',
            'tipo_documento'       => 'required|string|max:20',
            'numero_documento'     => 'required|string|max:20|unique:pacientes,numero_documento',
            'fecha_nacimiento'     => 'required|date|before:today',
            'fecha_ingreso'        => 'required|date',
            'contacto_emergencia'  => 'nullable|string|max:255',
            'telefono_emergencia'  => 'nullable|string|max:20',
            'contacto_emergencia_nombre'   => 'nullable|string|max:100',
            'contacto_emergencia_telefono' => 'nullable|string|max:20',
            'condicion_medica'     => 'nullable|string',
            'alergias'             => 'nullable|string',
            'medicamentos_actuales'=> 'nullable|string',
            'grado_dependencia'    => 'nullable|string|max:50',
            'tipo_dieta'           => 'nullable|string|max:50',
            'soporte_movilidad'    => 'nullable|string|max:50',
        ]);
        $p = Paciente::create($data);
        BitacoraSistema::registrar('CREAR', 'pacientes', $p->id_paciente, "Paciente creado: {$p->nombre_completo}");
        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load(['facturas.detalles.servicio']);
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $data = $request->validate([
            'nombres'              => 'required|string|max:100',
            'apellidos'            => 'required|string|max:100',
            'tipo_documento'       => 'required|string|max:20',
            'numero_documento'     => 'required|string|max:20|unique:pacientes,numero_documento,'.$paciente->id_paciente.',id_paciente',
            'fecha_nacimiento'     => 'required|date|before:today',
            'fecha_ingreso'        => 'required|date',
            'contacto_emergencia'  => 'nullable|string|max:255',
            'telefono_emergencia'  => 'nullable|string|max:20',
            'contacto_emergencia_nombre'   => 'nullable|string|max:100',
            'contacto_emergencia_telefono' => 'nullable|string|max:20',
            'condicion_medica'     => 'nullable|string',
            'alergias'             => 'nullable|string',
            'medicamentos_actuales'=> 'nullable|string',
            'grado_dependencia'    => 'nullable|string|max:50',
            'tipo_dieta'           => 'nullable|string|max:50',
            'soporte_movilidad'    => 'nullable|string|max:50',
            'estado'               => 'required|boolean',
        ]);
        $paciente->update($data);
        BitacoraSistema::registrar('EDITAR', 'pacientes', $paciente->id_paciente, "Paciente actualizado: {$paciente->nombre_completo}");
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->update(['estado' => 0]);
        BitacoraSistema::registrar('ELIMINAR', 'pacientes', $paciente->id_paciente, "Paciente desactivado");
        return redirect()->route('pacientes.index')->with('success', 'Paciente desactivado.');
    }
}
