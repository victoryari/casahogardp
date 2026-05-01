<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionEmpresa;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $config = ConfiguracionEmpresa::actual();
        return view('configuracion.index', compact('config'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'ruc'             => 'required|string|max:20',
            'razon_social'    => 'required|string|max:150',
            'nombre_comercial'=> 'required|string|max:150',
            'direccion'       => 'nullable|string|max:255',
            'telefono'        => 'nullable|string|max:20',
            'correo'          => 'nullable|email|max:100',
            'moneda'          => 'required|string|max:10',
        ]);

        $config = ConfiguracionEmpresa::actual();
        if ($config->exists) {
            $config->update($data);
        } else {
            ConfiguracionEmpresa::create($data);
        }

        BitacoraSistema::registrar('EDITAR', 'configuracion_empresa', null, 'Configuración actualizada');
        return redirect()->route('configuracion.index')->with('success', 'Configuración guardada correctamente.');
    }
}
