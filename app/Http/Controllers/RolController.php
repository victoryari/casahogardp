<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::withCount('usuarios')->orderBy('nombre_rol')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_rol'  => 'required|string|max:50|unique:roles,nombre_rol',
            'descripcion' => 'nullable|string|max:255',
        ]);
        $r = Rol::create($data);
        BitacoraSistema::registrar('CREAR', 'roles', $r->id_rol, "Rol creado: {$r->nombre_rol}");
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $data = $request->validate([
            'nombre_rol'  => 'required|string|max:50|unique:roles,nombre_rol,'.$rol->id_rol.',id_rol',
            'descripcion' => 'nullable|string|max:255',
            'estado'      => 'required|boolean',
        ]);
        $rol->update($data);
        BitacoraSistema::registrar('EDITAR', 'roles', $rol->id_rol, "Rol actualizado: {$rol->nombre_rol}");
        return redirect()->route('roles.index')->with('success', 'Rol actualizado.');
    }
}
