<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Prescripcion;
use App\Models\AdministracionMedicamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MedicationController extends Controller
{
    /**
     * Dashboard de Enfermería (Kardex del día)
     */
    public function dashboard(Request $request)
    {
        $fecha = $request->get('fecha', date('Y-m-d'));
        
        // Obtenemos las administraciones programadas para el día elegido
        $administraciones = AdministracionMedicamento::with(['prescripcion.paciente'])
            ->whereDate('fecha_hora_programada', $fecha)
            ->orderBy('fecha_hora_programada')
            ->get();

        return view('medication.dashboard', compact('administraciones', 'fecha'));
    }

    /**
     * Formulario para nueva prescripción
     */
    public function create(Paciente $paciente)
    {
        return view('medication.create', compact('paciente'));
    }

    /**
     * Guardar prescripción y generar primeras dosis
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_paciente' => 'required|exists:pacientes,id_paciente',
            'medicamento' => 'required|string|max:255',
            'dosis' => 'required|string|max:100',
            'frecuencia_horas' => 'required|integer|min:1',
            'via_administracion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'indicaciones' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $prescripcion = Prescripcion::create([
                'id_paciente' => $validated['id_paciente'],
                'medicamento' => $validated['medicamento'],
                'dosis' => $validated['dosis'],
                'frecuencia_horas' => $validated['frecuencia_horas'],
                'via_administracion' => $validated['via_administracion'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'] ?? null,
                'indicaciones' => $validated['indicaciones'] ?? null,
                'id_usuario_prescribe' => auth()->id(),
                'estado' => 'activa',
            ]);

            // Generar administraciones para las primeras 72 horas o hasta fecha_fin
            $this->generarDosis($prescripcion);
        });

        return redirect()->route('pacientes.show', $validated['id_paciente'])
            ->with('success', 'Prescripción médica registrada y cronograma generado.');
    }

    /**
     * Registrar administración de una dosis
     */
    public function administrar(Request $request, AdministracionMedicamento $administracion)
    {
        $administracion->update([
            'fecha_hora_real' => now(),
            'id_usuario_administra' => auth()->id(),
            'estado' => 'administrado',
            'observaciones' => $request->observaciones
        ]);

        return back()->with('success', 'Medicación administrada correctamente.');
    }

    /**
     * Lógica para generar las dosis programadas
     */
    private function generarDosis(Prescripcion $prescripcion)
    {
        $inicio = Carbon::parse($prescripcion->fecha_inicio);
        // Generamos dosis para 3 días (72h) inicialmente
        $limite = $prescripcion->fecha_fin ? Carbon::parse($prescripcion->fecha_fin) : $inicio->copy()->addDays(3);
        
        $actual = $inicio->copy();
        
        while ($actual <= $limite) {
            AdministracionMedicamento::create([
                'id_prescripcion' => $prescripcion->id_prescripcion,
                'fecha_hora_programada' => $actual,
                'estado' => 'pendiente',
            ]);
            
            $actual->addHours((int)$prescripcion->frecuencia_horas);
        }
    }
}
