<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Personal;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol', 'personal')->orderBy('nombre_usuario')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles    = Rol::where('estado', 1)->orderBy('nombre_rol')->get();
        $personal = Personal::where('estado', 1)->whereDoesntHave('usuario')->orderBy('apellidos')->get();
        return view('usuarios.create', compact('roles', 'personal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_rol'         => 'required|exists:roles,id_rol',
            'id_personal'    => 'nullable|exists:personal,id_personal',
            'nombre_usuario' => 'required|string|max:100|unique:usuarios,nombre_usuario',
            'password'       => 'required|string|min:8|confirmed',
        ]);
        $u = Usuario::create([
            'id_rol'         => $data['id_rol'],
            'id_personal'    => $data['id_personal'] ?? null,
            'nombre_usuario' => $data['nombre_usuario'],
            'password_hash'  => Hash::make($data['password']),
        ]);
        BitacoraSistema::registrar('CREAR', 'usuarios', $u->id_usuario, "Usuario creado: {$u->nombre_usuario}");
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        $roles    = Rol::where('estado', 1)->orderBy('nombre_rol')->get();
        $personal = Personal::where('estado', 1)
            ->where(fn($q) => $q->whereDoesntHave('usuario')->orWhere('id_personal', $usuario->id_personal))
            ->orderBy('apellidos')->get();
        return view('usuarios.edit', compact('usuario', 'roles', 'personal'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $rules = [
            'id_rol'         => 'required|exists:roles,id_rol',
            'id_personal'    => 'nullable|exists:personal,id_personal',
            'nombre_usuario' => 'required|string|max:100|unique:usuarios,nombre_usuario,'.$usuario->id_usuario.',id_usuario',
            'estado'         => 'required|boolean',
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }
        $data = $request->validate($rules);

        $update = [
            'id_rol'         => $data['id_rol'],
            'id_personal'    => $data['id_personal'] ?? null,
            'nombre_usuario' => $data['nombre_usuario'],
            'estado'         => $data['estado'],
        ];
        if ($request->filled('password')) {
            $update['password_hash'] = Hash::make($data['password']);
        }
        $usuario->update($update);
        BitacoraSistema::registrar('EDITAR', 'usuarios', $usuario->id_usuario, "Usuario actualizado");
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id_usuario === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }
        $usuario->update(['estado' => 0]);
        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado.');
    }
}
