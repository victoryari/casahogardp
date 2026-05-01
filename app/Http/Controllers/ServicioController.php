<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicio::query();
        if ($request->filled('buscar')) {
            $query->where('nombre_servicio', 'like', "%{$request->buscar}%")
                  ->orWhere('codigo_servicio', 'like', "%{$request->buscar}%");
        }
        $servicios = $query->orderBy('nombre_servicio')->paginate(15)->withQueryString();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo_servicio'   => 'nullable|string|max:20|unique:servicios,codigo_servicio',
            'nombre_servicio'   => 'required|string|max:150',
            'descripcion'       => 'nullable|string',
            'precio_referencial'=> 'required|numeric|min:0',
        ]);
        $s = Servicio::create($data);
        BitacoraSistema::registrar('CREAR', 'servicios', $s->id_servicio, "Servicio creado: {$s->nombre_servicio}");
        return redirect()->route('servicios.index')->with('success', 'Servicio registrado.');
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'codigo_servicio'   => 'nullable|string|max:20|unique:servicios,codigo_servicio,'.$servicio->id_servicio.',id_servicio',
            'nombre_servicio'   => 'required|string|max:150',
            'descripcion'       => 'nullable|string',
            'precio_referencial'=> 'required|numeric|min:0',
            'estado'            => 'required|boolean',
        ]);
        $servicio->update($data);
        BitacoraSistema::registrar('EDITAR', 'servicios', $servicio->id_servicio, "Servicio actualizado");
        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->update(['estado' => 0]);
        return redirect()->route('servicios.index')->with('success', 'Servicio desactivado.');
    }
}
