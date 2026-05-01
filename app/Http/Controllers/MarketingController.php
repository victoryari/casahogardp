<?php

namespace App\Http\Controllers;

use App\Models\ProspectoMarketing;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index(Request $request)
    {
        $query = ProspectoMarketing::query();
        if ($request->filled('buscar')) {
            $query->where('nombre_contacto', 'like', "%{$request->buscar}%");
        }
        if ($request->filled('estado_seguimiento')) {
            $query->where('estado_seguimiento', $request->estado_seguimiento);
        }
        $prospectos = $query->latest('fecha_registro')->paginate(15)->withQueryString();
        return view('marketing.index', compact('prospectos'));
    }

    public function create()
    {
        return view('marketing.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_contacto'   => 'required|string|max:150',
            'telefono'          => 'nullable|string|max:20',
            'correo'            => 'nullable|email|max:100',
            'medio_contacto'    => 'required|string|max:50',
            'interes_mostrado'  => 'nullable|string',
            'estado_seguimiento'=> 'required|string|max:50',
        ]);
        $p = ProspectoMarketing::create($data);
        BitacoraSistema::registrar('CREAR', 'prospectos_marketing', $p->id_prospecto, "Prospecto: {$p->nombre_contacto}");
        return redirect()->route('marketing.index')->with('success', 'Prospecto registrado.');
    }

    public function edit(ProspectoMarketing $marketing)
    {
        return view('marketing.edit', compact('marketing'));
    }

    public function update(Request $request, ProspectoMarketing $marketing)
    {
        $data = $request->validate([
            'nombre_contacto'   => 'required|string|max:150',
            'telefono'          => 'nullable|string|max:20',
            'correo'            => 'nullable|email|max:100',
            'medio_contacto'    => 'required|string|max:50',
            'interes_mostrado'  => 'nullable|string',
            'estado_seguimiento'=> 'required|string|max:50',
            'estado'            => 'required|boolean',
        ]);
        $marketing->update($data);
        BitacoraSistema::registrar('EDITAR', 'prospectos_marketing', $marketing->id_prospecto, "Prospecto actualizado");
        return redirect()->route('marketing.index')->with('success', 'Prospecto actualizado.');
    }

    public function destroy(ProspectoMarketing $marketing)
    {
        $marketing->update(['estado' => 0]);
        return redirect()->route('marketing.index')->with('success', 'Prospecto desactivado.');
    }
}
