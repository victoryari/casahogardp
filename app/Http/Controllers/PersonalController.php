<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        $query = Personal::query();
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
        $personal = $query->orderBy('apellidos')->paginate(15)->withQueryString();
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        return view('personal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres'           => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'tipo_documento'    => 'required|string|max:20',
            'numero_documento'  => 'required|string|max:20|unique:personal,numero_documento',
            'cargo'             => 'required|string|max:100',
            'modalidad_contrato'=> 'required|string|max:50',
            'telefono'          => 'nullable|string|max:20',
        ]);
        $p = Personal::create($data);
        BitacoraSistema::registrar('CREAR', 'personal', $p->id_personal, "Personal creado: {$p->nombre_completo}");
        return redirect()->route('personal.index')->with('success', 'Personal registrado correctamente.');
    }

    public function edit(Personal $personal)
    {
        return view('personal.edit', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $data = $request->validate([
            'nombres'           => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'tipo_documento'    => 'required|string|max:20',
            'numero_documento'  => 'required|string|max:20|unique:personal,numero_documento,'.$personal->id_personal.',id_personal',
            'cargo'             => 'required|string|max:100',
            'modalidad_contrato'=> 'required|string|max:50',
            'telefono'          => 'nullable|string|max:20',
            'estado'            => 'required|boolean',
        ]);
        $personal->update($data);
        BitacoraSistema::registrar('EDITAR', 'personal', $personal->id_personal, "Personal actualizado: {$personal->nombre_completo}");
        return redirect()->route('personal.index')->with('success', 'Personal actualizado correctamente.');
    }

    public function destroy(Personal $personal)
    {
        $personal->update(['estado' => 0]);
        BitacoraSistema::registrar('ELIMINAR', 'personal', $personal->id_personal, "Personal desactivado: {$personal->nombre_completo}");
        return redirect()->route('personal.index')->with('success', 'Personal desactivado.');
    }
}
